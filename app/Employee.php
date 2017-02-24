<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
	protected $primaryKey = 'employee_id';

	protected $fillable = [
		'name',
		'email',
		'phone'
	];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}

	public function position()
	{
		return $this->hasOne('App\Position', 'position_id', 'position_id');
	}

	public function appointments()
	{
		return $this->hasMany(Appointment::class);
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	// defining M:N relationship
	public function services()
	{
		return $this->belongsToMany(Service::class, 'employee_provides_service', 'employee_id', 'service_id');
	}

	public function settings()
	{
		return $this->hasOne('App\EmployeeSetting', 'employee_id', 'employee_id');
	}

	/**
	 * Возвращает
	 *
	 * @param null $startDateTime string start datetime. If not set current timestamp is used
	 * @param null $endDateTime string end datetime. If not set end of current month is used
	 * @param bool|FALSE $forWidget
	 *
	 * @return array | bool
	 */
	public function getFreeTimeIntervals($startDateTime = NULL, $endDateTime = NULL, $forWidget = FALSE) {
		/*
		schedules
			work_start		// 2017-02-10 09:30:00
			work_end		// 2017-02-10 13:00:00
			employee_id


		appointments
			start
			end
			employee_id

		// TODO: так же учитвать employee_settings
		employee_settings
			session_start	// с 08:00, может быть NULL  - regexp to parse /(\d?\d:\d\d)/
			session_end		// по 19:30, может быть NULL
		*/

		$startDateTime = new \DateTime($startDateTime);
		$startDateTime = $startDateTime->format('Y-m-d H:i:s');

		$endDateTime = new \DateTime($endDateTime);
		$endDateTime = $endDateTime->format('Y-m-t') . ' 23:59:59';		// t returns the number of days in the month for given date

		// Отбираем интервалы расписаний в пределах нужного срока и Сортируем их по возрастанию
		$schedules = DB::select(
			"SELECT ".
				"(CASE WHEN work_start < '$startDateTime' THEN '$startDateTime' ELSE work_start END) AS work_start, ".
				"(CASE WHEN work_end > '$endDateTime' THEN '$endDateTime' ELSE work_end END) AS work_end ".
			"FROM schedules ".
			"WHERE employee_id=? AND ".
			"(work_start >= '$startDateTime' AND work_end <= '$endDateTime')  OR ".
			"(work_start < '$startDateTime' AND work_end > '$startDateTime' AND work_end <= '$endDateTime') OR ".
			"(work_start >= '$startDateTime' AND work_start<'$endDateTime' AND work_end > '$endDateTime') OR ".
			"(work_start < '$startDateTime' AND work_end > '$endDateTime') ".
			"ORDER BY work_start ASC",
			[$this->employee_id]
		);
		if (count($schedules) == 0) {
			return array();
		}

		// TODO: хорошо бы не давать создавать записи которые заканчиваются позже чем рабочий интервал работника
		// Отбираем записи в пределах того же срока и тоже Сортируем по возрастанию (по дате начала)
		$appts = DB::select(
			"SELECT ".
 				"(CASE WHEN start < '$startDateTime' THEN '$startDateTime' ELSE start END) AS start, ".
				"(CASE WHEN `end` > '$endDateTime' THEN '$endDateTime' ELSE `end` END) AS `end` ".
			"FROM appointments ".
			"WHERE employee_id=? AND (start BETWEEN '$startDateTime' AND '$endDateTime') OR (end BETWEEN '$startDateTime' AND '$endDateTime') ".
			"ORDER BY start ASC",
			[$this->employee_id]
		);
		if (count($appts) == 0) {
			return $schedules;
		}

		//В пхп в цикле проходим по массиву записей (appointments) и вызываем функцию X(массив интервалов расписаний, конкретная запись) которая вернет новый массив интервалов расписаний
		foreach($appts AS $apt) {
			$this->subtractAppointmentsPeriodFromWorkSchedule($schedules, $apt);
		}

		return $schedules;
	}

	/**
	 * Генерит набор свободных для записи интервалов времени на основе расписания и уже существующих записей
	 *
	 * @param $schedules array of objects {'work_start' => 'YYYY-mm-dd H:i:s', 'work_end' => 'YYYY-mm-dd H:i:s'}
	 * @param $apt
	 * @return array
	 *
	 */
	private function subtractAppointmentsPeriodFromWorkSchedule(&$schedules, $apt) {
		/*
		Функция берет дату начала записи и, пробегаясь по массиву интервалов расписаний ищет подходящий. Найдя, бъет его на 2 новых или сокращает

		Is - начало интервала. Ie - конец интервала
		As, Ae
		Запись попадает в интервал, если
		(As>=Is AND Ae<=Ie) OR (As<Is AND Ae>Is AND Ae<=Ie)		// т.к. мы можем обрезать начало интервала расписания при выборке, нужно учитывать, что начало записи может лежать до начала интервала расписания


		Новый интервал
		If As<=Is AND (Ae>=Ie) Then весь интервал занят, удаляем его из списка
		If As<=Is AND Ae<Ie Then новый интервал Is=Ae, Ie=Ie
		If As>Is AND Ae<Ie Then два новых интервала Is1=Is, Ie1=As; Is2=Ae, Ie2=Ie
		If As>Is AND Ae>=Ie Then новый интервал Is=Is, Ie=As
		*/

		$appStartDt = new \DateTime($apt->start);
		$appEndDt = new \DateTime($apt->end);

		for ($i=0; $i<count($schedules); $i++) {
			$schdIntStart = new \DateTime($schedules[$i]->work_start);
			$schdIntEnd = new \DateTime($schedules[$i]->work_end);

			// запись попадает в интервал
			if ( ($appStartDt >= $schdIntStart AND $appEndDt <= $schdIntEnd) OR ($appStartDt < $schdIntStart AND $appEndDt > $schdIntStart AND $appEndDt <= $schdIntEnd)) {

				if ($appStartDt <= $schdIntStart AND ($appEndDt == $schdIntEnd)) {		// If As<=Is AND (Ae>=Ie) Then весь интервал занят, удаляем его из списка
					unset($schedules[$i]);
					$schedules = array_values($schedules);	// восстанавливаем ключи массива
					break;

				} elseif ($appStartDt <= $schdIntStart AND $appEndDt < $schdIntEnd ) {	// If As<=Is AND Ae<Ie Then новый интервал Is=Ae, Ie=Ie
					$schedules[$i]->work_start = $apt->end;
					break;

				} elseif ($appStartDt > $schdIntStart AND $appEndDt < $schdIntEnd) {	// If As>Is AND Ae<Ie Then два новых интервала Is1=Is, Ie1=As; Is2=Ae, Ie2=Ie

					$newSegnemts = array(
						(object) array(
							'work_start' 	=> $schedules[$i]->work_start,
							'work_end' 		=> $apt->start
						),
						(object) array(
							'work_start' 	=> $apt->end,
							'work_end' 		=> $schedules[$i]->work_end
						)
					);
					$newSchedulesP1 = array_slice($schedules, 0, $i);
					$newSchedulesP2 = array_slice($schedules, $i+1);
					$schedules = array_merge($newSchedulesP1, $newSegnemts, $newSchedulesP2);
					unset($newSchedulesP1, $newSchedulesP2, $newSegnemts);
					break;

				} elseif ($appStartDt > $schdIntStart AND $appEndDt >= $schdIntEnd) {	// If As>Is AND Ae>=Ie Then новый интервал Is=Is, Ie=As
					$schedules[$i]->work_end = $apt->start;
					break;
				}

			}
		}

		return $schedules;
	}

	/**
	 * Возвращает свободные для записи даты (для виджета)
	 *
	 * @return array
	 */
	public function getFreeWorkDaysForCurrMonth() {
		// TODO: принимать в кач-ве параметра объект Appointment и использовать длительность при отборе дней (проверять что разница между end и start >= длительности услуги)

		$dates = array();
		$intervals = $this->getFreeTimeIntervals(NULL, NULL, TRUE);

		foreach ($intervals AS $int) {
			$start = new \DateTime($int->work_start);
			$end = new \DateTime($int->work_end);

			$diff = $start->diff($end);
			$minutes = $diff->format('%i');
			$minutes = (substr($minutes, 0, 1) == '0') ? (int)substr($minutes, 1, 1) : (int)$minutes;

			if ($diff->i >= 10 OR $diff->h > 0 OR $diff->d > 0 OR $diff->m > 0 OR $diff->y > 0) {
				$dates[$start->format('Y-m-d')] = 1;
			}

			// проверка, включать ли следующий день как свободный для записи
			$nDayStart = new \DateTime($start->format('Y-m-d').' 00:00:00 + 1 day');
			$tmpDiff = $nDayStart->diff($end);
			if ($tmpDiff->i >= 10 OR $tmpDiff->h > 0 OR $tmpDiff->d > 0) {
				$dates[$end->format('Y-m-d')] = 1;
			}
		}

		return array_keys($dates);
	}
}

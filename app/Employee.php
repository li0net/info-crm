<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * App\Employee
 *
 * @property int $employee_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $organization_id
 * @property int $position_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $spec
 * @property string $descr
 * @property string $avatar_image_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Appointment[] $appointments
 * @property-read \App\Organization $organization
 * @property-read \App\Position $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Schedule[] $schedules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Service[] $services
 * @property-read \App\EmployeeSetting $settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereAvatarImageName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereDescr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee wherePositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereSpec($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

	public function services()
	{
		return $this->belongsToMany(Service::class, 'employee_provides_service', 'employee_id', 'service_id')->withPivot('duration', 'routing_id');
	}

	public function settings()
	{
		return $this->hasOne('App\EmployeeSetting', 'employee_id', 'employee_id');
	}

    public function wageSchemes() {
        return $this->belongsToMany(WageScheme::class, 'wages', 'employee_id', 'scheme_id')->withPivot('scheme_start');
    }

	public function scheduleScheme()
	{
		return $this->hasOne('App\ScheduleScheme');
	}

	public function calculatedWage()
	{
		return $this->hasMany('App\CalculatedWage');
	}

	/**
	 * Возвращает свободные для записи интервалы времени у текущего работника
	 *
	 * @param null $startDateTime string start datetime. If not set current timestamp is used
	 * @param null $endDateTime string end datetime. If not set end of current month is used
	 * @param bool|FALSE $forWidget
	 *
	 * @return array | bool - [{'work_start' => '2017-02-20 10:00:00', 'work_end' => '2017-02-20 16:30:00'}, ...]
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

		if (is_null($endDateTime)) {
			$endDateTime = new \DateTime();
			$endDateTime = $endDateTime->format('Y-m-t') . ' 23:59:59';        // t returns the number of days in the month for given date
		} else {
			$endDateTime = new \DateTime($endDateTime);
			$endDateTime = $endDateTime->format('Y-m-d H:i:s');
		}

		// Отбираем интервалы расписаний в пределах нужного срока и Сортируем их по возрастанию
		$schedules = DB::select(
			"SELECT ".
				"(CASE WHEN work_start < '$startDateTime' THEN '$startDateTime' ELSE work_start END) AS work_start, ".
				"(CASE WHEN work_end > '$endDateTime' THEN '$endDateTime' ELSE work_end END) AS work_end ".
			"FROM schedules ".
			"WHERE employee_id=? AND ".
			"(".
                "(work_start >= '$startDateTime' AND work_end <= '$endDateTime')  OR ".
			    "(work_start < '$startDateTime' AND work_end > '$startDateTime' AND work_end <= '$endDateTime') OR ".
			    "(work_start >= '$startDateTime' AND work_start<'$endDateTime' AND work_end > '$endDateTime') OR ".
			    "(work_start < '$startDateTime' AND work_end > '$endDateTime')".
			") ".
			"ORDER BY work_start ASC",
			[$this->employee_id]
		);
		if (count($schedules) == 0) {
			return array();
		}
        //Log::info(__METHOD__.' controller: schedules count'.count($schedules));

		// TODO: хорошо бы не давать создавать записи которые заканчиваются позже чем рабочий интервал работника
		// Отбираем записи в пределах того же срока и тоже Сортируем по возрастанию (по дате начала)
		$appts = DB::select(
			"SELECT ".
 				"(CASE WHEN a.start < '$startDateTime' THEN '$startDateTime' ELSE start END) AS start, ".
				"(CASE WHEN a.`end` > '$endDateTime' THEN '$endDateTime' ELSE `end` END) AS `end`, ".
                "s.max_num_appointments ".
			"FROM appointments a ".
            "JOIN services s ON s.service_id=a.service_id ".
			"WHERE a.employee_id=? AND (a.start BETWEEN '$startDateTime' AND '$endDateTime') OR (a.end BETWEEN '$startDateTime' AND '$endDateTime') ".
			"ORDER BY a.start ASC",
			[$this->employee_id]
		);
		if (count($appts) == 0) {
			return $schedules;
		}
        //Log::info(__METHOD__.' controller: appts count'.count($appts));

		// Обработка записи более одного клиента на один интервал времени
        $apptsByMaxClients = array();
        $singleRecordIntervals = array();
        foreach ($appts AS $appt) {
            // Если у Service кол-во одновременно обслуживаемых клиентов (max_num_appointments) > 1
            if ($appt->max_num_appointments > 1) {
                $apptsByMaxClients[$appt->max_num_appointments][] = [
                    'start' => $appt->start,
                    'end'   => $appt->end
                ];
            } else {
                $singleRecordIntervals[] = [
                    'start' => $appt->start,
                    'end'   => $appt->end
                ];
            }
        }
        if (count($apptsByMaxClients)>0) {
            foreach ($apptsByMaxClients AS $maxNum => $selAppts) {
                // передаем максимальное кол-во одновременных записей и отобранные записи такого типа, чтобы получить интервалы в которых макс кол-во записей уже достигнуто
                $filteredIntervals = $this->filterMaxNumReachedIntervals($selAppts, $maxNum);
                if (count($filteredIntervals) > 0) {
                    $singleRecordIntervals = array_merge($singleRecordIntervals, $filteredIntervals);
                }
            }

            if (count($singleRecordIntervals) > 0) {
                usort($singleRecordIntervals, function ($a, $b) {
                    $aS = new \DateTime($a['start']);
                    $bS = new \DateTime($b['start']);

                    if ($aS == $bS) {
                        return 0;
                    }
                    return ($aS < $bS) ? -1 : 1;
                });
            }
        }

        $appts = $singleRecordIntervals;

		//В пхп в цикле проходим по массиву записей (appointments) и вызываем функцию X(массив интервалов расписаний, конкретная запись) которая вернет новый массив интервалов расписаний
		foreach($appts AS $apt) {
			$this->subtractAppointmentsPeriodFromWorkSchedule($schedules, (object)$apt);
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
	public function subtractAppointmentsPeriodFromWorkSchedule(&$schedules, $apt) {
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
							'work_end' 		=> $apt->start,
                            'employee_id'   => (isset($schedules[$i]->employee_id)) ? $schedules[$i]->employee_id : null
						),
						(object) array(
							'work_start' 	=> $apt->end,
							'work_end' 		=> $schedules[$i]->work_end,
                            'employee_id'   => (isset($schedules[$i]->employee_id)) ? $schedules[$i]->employee_id : null
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

	/**
	 * Возвращает временные метки свободные для записи на выбранный день на конкретную услугу
	 *
	 * @param $day string 'YYYY-mm-dd'
	 * @param $service Service model object
	 *
	 * @return array|bool  ['10:30', '11:15', '14:00', '14:45']
	 */
	public function getFreeWorkTimesForDay($day, Service $service) {
		if (!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $day)) {
			return FALSE;
		}

		$ss = '00';
		list($sh, $sm, $ss) = explode(':', $service->duration);		//'00:45:00'
		$serviceDurationInt = new \DateInterval("PT{$sh}H{$sm}M{$ss}S");

		$freeTimeIntervals = $this->getFreeTimeIntervals($day . '00:00:00', $day . '23:59:59', TRUE);
		/*[
			{
				'work_start' => '2017-02-20 10:00:00',
				'work_end' => '2017-02-20 16:30:00'
			},
			{
				'work_start' => '2017-02-20 17:30:00',
				'work_end' => '2017-02-20 19:00:00'
			}
		]*/

		$availableTimes = array();
		foreach($freeTimeIntervals AS $int) {
			$intStart = new \DateTime($int->work_start);
			$intEnd = new \DateTime($int->work_end);

			$currDT = $intStart->add($serviceDurationInt);
			while($currDT <= $intEnd) {
				$selStartTime = clone $currDT;
				$selStartTime = $selStartTime->sub($serviceDurationInt);
				$availableTimes[] = $selStartTime->format('H:i');

				$currDT = $currDT->add($serviceDurationInt);
			}
		}

		return $availableTimes;
	}

    public function filterMaxNumReachedIntervals($appts, $maxNum) {
        /*
        1) Сортируем все записи по SD (start date) - $appts УЖЕ СОРТИРОВАНЫ, т.к. ORDER BY a.start
        2) Во вложенном цикле берем i запись и проходимся по всем остальным j до тех пор пока EDi (end date i записи) > SDj
            2.1) проверяем есть ли пересечение (очевидно, что по условию выше пересечение будет, если найдется хоть одна такая запись j) - интервал пересечения SDj до (EDi>EDj) ? EDj : EDi
            2.2) записываем интервал пересечения и кол-во в структуру вида
                    $intercections = array(
                        array(
                            'start' => SDj,
                            'end'   => IE (interval end из 2.1),
                            'count' => 1 // потребуется для последующего поиска пересечений среди пересечений
                        ),
                        ..
                    )

        3) Пробегаемся по $intercections также во вложенном цикле, если находим пересечение пересечений записываем в
                    $intercectionsNew = array(
                        array(
                            'start' => SDj,
                            'end'   => IE (interval end из 2.1),
                            'count' => $intercections[i]['count'] + $intercections[j]['count'] + 1
                        ),
                        ..
                    )
        */

        //Log::info(__METHOD__.' $appts:'.print_r($appts, TRUE));
        $intersections = [];
        for ($i=0; $i<count($appts); $i++) {
            $iS = new \DateTime($appts[$i]['start']);
            $iE = new \DateTime($appts[$i]['end']);

            for ($j=$i+1; $j<count($appts); $j++) {
                //if ($i == $j) continue;

                $jS = new \DateTime($appts[$j]['start']);
                $jE = new \DateTime($appts[$j]['end']);
                if ($jS >= $iE) break;   // Во вложенном цикле берем i запись и проходимся по всем остальным j до тех пор пока EDi (end date i записи) > SDj

                //(EDi>EDj) ? EDj : EDi
                $intE = ($iE > $jE) ? $jE : $iE;
                $intersections[] = [
                    'start'     => $jS,
                    'end'       => $intE,
                    'count'     => 1
                ];
            }
        }

        $maxNumReached = FALSE;
        Log::info(__METHOD__.' $intersections:'.print_r($intersections, TRUE));
        do {
            $intersectionsNew = [];

            for ($i=0; $i<count($intersections); $i++) {
                $iS = $intersections[$i]['start'];
                $iE = $intersections[$i]['end'];

                for ($j=$i+1; $j<count($intersections); $j++) {
                    //if ($i == $j) continue;

                    $jS = $intersections[$j]['start'];
                    $jE = $intersections[$j]['end'];
                    if ($jS > $iE) break;   // Во вложенном цикле берем i запись и проходимся по всем остальным j до тех пор пока EDi (end date i записи) > SDj

                    //(EDi>EDj) ? EDj : EDi
                    $intE = ($iE > $jE) ? $jE : $iE;
                    $intersectionsNew[] = [
                        'start'     => $jS,
                        'end'       => $intE,
                        'count'     => $intersections[$i]['count'] + $intersections[$j]['count'] + 1
                    ];
                    Log::info(__METHOD__.' $intersectionsNew:'.print_r($intersectionsNew, TRUE));

                    // Если ВСЕ пересечения достигли предельного уровня записываем в $maxNumReached = TRUE;
                    if (($intersections[$i]['count'] + $intersections[$j]['count'] + 1) >= $maxNum) {
                        $maxNumReached = TRUE;
                    } else {
                        $maxNumReached = FALSE;
                    }
                }
            }

            if (count($intersectionsNew) > 0) $intersections = $intersectionsNew;
            if ($maxNumReached) break;
        } while (count($intersectionsNew)>0);

        $res = [];
        foreach ($intersections AS $intersection) {
			if ($intersection['count'] == 1) $intersection['count'] = 2;
            if ($intersection['count'] >= $maxNum) {
                $res[] = [
                    'start' => $intersection['start']->format('Y-m-d H:i:s'),
                    'end'   => $intersection['end']->format('Y-m-d H:i:s')
                ];
            }
        }

        return $res;
    }

	public function calculateWage($startDate, $endDate, $payAfterCalculation=false) {
        //4)Период расчета - месяц. Если есть фикса - выплачиваем ее, вне зависимости от кол-ва отработанных дней.

        // пока что будет только одна wage_scheme на работника, чтобы не усложнять
        $wageScheme = $this->wageSchemes()->where('scheme_start', '<=', $startDate)->first();
        if (!$wageScheme) {
            Log::error(__METHOD__.' No wage scheme found for employee '.$this->employee_id.' and start_date '.$startDate);
            return FALSE;
        }

        /*
        $scheme = $wageSchemes[0];
        $scheme->services_percent;
        $scheme->service_unit;
        $scheme->products_percent;
        $scheme->products_unit;
        $scheme->wage_rate;
        $scheme->wage_rate_period;
        $scheme->is_client_discount_counted;
        $scheme->is_material_cost_counted;
        //$scheme->organization_id = $request->user()->organization_id;
        */

        $wageSum = (float)0;

        /*
        0) получить wage_scheme для текущего работника

        1) нужно получить кол-во часов которые работник отработал за [$startDate, $endDate]
            если есть оклад "за месяц", то просто сразу добавляем его к сумме зарплаты

        2) делаем выборку всех завершенных (state='finished') аппойнтментов за период $startDate, $endDate
            нужно получить  a.service_price, a.service_discount, a.service_sum, a.start, a.end,
            s.name (LEFT JOIN, чтобы если service будет удален все равно можно было бы учесть работу и сгенерить ведомость)

        3) нужно получить записи о продаже товаров, которые произошли в рассматриваемый период (transactions.product_id)
            здесь надо учитывать, что процент вознаграждения работника может браться от разничей м/у ценой продажи и себестоимостью товара (? как считать)
            products.title (LEFT JOIN), p.article (LEFT JOIN), p.price (LEFT JOIN), transactions.amount
        */

        // Оклад
        $salary = (float)0;
        $wageRate = (float)$wageScheme->wage_rate;

        // wage_rate_period	enum('hour','day','month')
        // Если ставка не ненулевая и одного из двух типов - hour/day
        if ($wageRate > 0 AND ($wageScheme->wage_rate_period == 'hour' OR $wageScheme->wage_rate_period == 'day')) {
            // Отбираем интервалы расписаний в пределах нужного срока
            $workTimes = DB::select(
                "SELECT " .
                "TIMESTAMPDIFF(MINUTE, " .
                "(CASE WHEN work_start < '$startDate' THEN '$startDate' ELSE work_start END), " .
                "(CASE WHEN work_end > '$endDate' THEN '$endDate' ELSE work_end END) " .
                ") AS diff_minutes, " .
                "DATE((CASE WHEN work_start < '$startDate' THEN '$startDate' ELSE work_start END)) AS day " .
                "FROM schedules " .
                "WHERE employee_id=? AND " .
                "(" .
                "(work_start >= '$startDate' AND work_end <= '$endDate')  OR " .
                "(work_start < '$startDate' AND work_end > '$startDate' AND work_end <= '$endDate') OR " .
                "(work_start >= '$startDate' AND work_start<'$endDate' AND work_end > '$endDate') OR " .
                "(work_start < '$startDate' AND work_end > '$endDate')" .
                ")",
                [$this->employee_id]
            );

            $minutes = 0;
            $daysWorked = [];
            if (count($workTimes) != 0) {
                foreach ($workTimes AS $workTime) {
                    $minutes += (int)$workTime->diff_minutes;
                    $daysWorked[$workTime->day] = true;
                }

                // wage_rate	decimal(12,2)
                // wage_rate_period	enum('hour','day','month')
                if ($wageScheme->wage_rate_period == 'hour') {
                    // 3)Значение отработанного времени не округляем - часы и минуты переводим в десятичный формат и умножая на почасовку, получаем дробное, в общем случае, значение заработной платы.
                    $salary = ($minutes / 60) * $wageRate;
                } elseif ($wageScheme->wage_rate_period == 'day') {
                    $salary = count($daysWorked) * $wageRate;
                }
            }
        }
		if ($wageScheme->wage_rate_period == 'month') {
			// 1) Фикса должна рассчитываться вне зависимости от кол-ва отработанного времени, однако должна быть возможность ее отключить(обнулить).
			// 2)Соответственно, понятия минимально отработанного времени не будет
			$salary = $wageRate;
		}

        // Отбираем записи в пределах того же срока и тоже Сортируем по возрастанию (по дате начала)
        $servicesPercentSum = (float)0;
        $servicesPerformedInfo = [];
        if ((int)$wageScheme->services_percent > 0) {
            $appts = DB::select(
                "SELECT a.id, a.service_price, a.service_discount, a.service_sum, a.start, a.end, " .
                "s.name " .
                "FROM appointments a " .
                "LEFT JOIN services s ON s.service_id=a.service_id " .
                "WHERE a.employee_id=? AND (a.start BETWEEN '$startDate' AND '$endDate') OR (a.end BETWEEN '$startDate' AND '$endDate') AND " .
                "a.state='finished' ".
                "ORDER BY a.start ASC",
                [$this->employee_id]
            );

            if (count($appts) != 0) {
                foreach ($appts AS $apt) {
                    if (trim($apt->name) == '') {
                        $appName = 'Unknown';   // TODO: translate
                    } else {
                        $appName = $apt->name;
                    }

                    $servicesPercentSum += (float)$apt->service_sum * (int)$wageScheme->services_percent;
                    $servicesPerformedInfo[$apt->start][$apt->id] = [
                        'start'         => $apt->start,
                        'end'           => $apt->end,
                        'title'         => $appName,
                        'price'         => $apt->service_price,
                        'discount'      => $apt->service_discount,
                        'total'         => $apt->service_sum,
                        'percent_earned' => (float)$apt->service_sum * (int)$wageScheme->services_percent
                    ];
                }
            }

        }

        // 3
        $productsSoldInfo = [];
        $productsPercentSum = (float)0;
        if ((int)$wageScheme->products_percent > 0) {
            $productTransactions = DB::select(
                "SELECT t.transaction_id, t.amount, t.created_at, t.product_id, p.title, p.article, p.price " .
                "FROM transactions t " .
                "LEFT JOIN products p ON p.product_id=t.product_id " .
                "WHERE t.employee_id=? AND " .
                "(t.created_at >= '$startDate' AND t.created_at <= '$endDate')",
                [$this->employee_id]
            );

            if (count($productTransactions) != 0) {
                foreach ($productTransactions AS $pt) {
                    if (trim($pt->title) == '') {
                        $productName = 'Unknown '.$pt->product_id;   // TODO: translate
                    } else {
                        $productName = $pt->title;
                    }

                    $productsPercentSum += (float)$pt->amount * (int)$wageScheme->products_percent;
                    // TODO: в transations надо добавить кол-во проданного товара, скидку покупателю, итоговую цену с учетом скидки и добавить это в массив $productsSoldInfo
                    $productsSoldInfo[$pt->created_at][$pt->transaction_id] = [
                        'date'          => $pt->created_at,
                        'product_title' => $productName,
                        'amount'        => $pt->amount,
                        'percent_earned' => (float)$pt->amount * (int)$wageScheme->products_percent
                    ];
                }
            }
        }

        $totalAmount = round($salary + $servicesPercentSum + $productsPercentSum, 2, PHP_ROUND_HALF_UP);

        // TODO: добавить обработку параметра $payAfterCalculation - сразу же помечать записи из transactions и appointments(?) как оплаченные (ни в какаом случае не учитываем их в последующих расчетах зп) И пишем в calculated_wages дату оплаты и id юзера который "оплатил"

        // TODO: генерить pdf ведомость из $servicesPerformedInfo и $productsSoldInfo
        // TODO: делать запись о расчитанной зарплате в новой таблице calculated_wages, в ней должен быть флаг is_payed и поля calculation_start, calculation_end, employee_id, calculated_by, payed_by, wage_scheme_id
        /*
        $table->integer('employee_id')->unsigned();
        $table->integer('wage_scheme_id')->unsigned();
        $table->dateTime('date_calculated');
        $table->dateTime('wage_period_start');
        $table->dateTime('wage_period_end');
        $table->text('appointments_data')->nullable();
        $table->text('products_data')->nullable();
        $table->decimal('total_amount', 10, 2);
        $table->dateTime('date_payed')->nullable();
        $table->integer('payed_by')->unsigned()->nullable();
        */
        $calculatedWage = CalculatedWage::create([
            'employee_id'       => $this->employee_id,
            'wage_scheme_id'    => $wageScheme->scheme_id,
            'date_calculated'   => date('Y-m-d H:i:s'),
            'wage_period_start' => $startDate,
            'wage_period_end'   => $endDate,
            'appointments_data' => json_encode($servicesPerformedInfo),
            'products_data'     => json_encode($productsSoldInfo),          // сюда попадут переведенные фразы - доработать
            'total_amount'      => $totalAmount
        ]);

        //  если запись в calculated_wages есть, не даем заново расчитывать зп за пересекающийся период
        //  при нажатии кнопки Выплатить зп - устанавливаем is_payed=1 и в транзакции помечаем записи из transactions и appointments(?) как оплаченные (ни в какаом случае не учитываем их в последующих расчетах зп)

        return $totalAmount;
    }

    public function generatePayroll($appointmentsData = null, $productsData = null) {
        if (is_null($appointmentsData) AND is_null($productsData)) {
            return FALSE;
            // TODO: throw exception or return error text in other way
        }

        //use PDF;
        view()->share([
            'apps' =>  $appointmentsData,
            'products' => $productsData
        ]);

        if(request()->has('download')){
            $pdf = PDF::loadView('employee.pdf.payroll');
            return $pdf->download('payroll.pdf');       // TODO: add employee name and date
        }

        return view('employee.pdf.payroll');
    }

}

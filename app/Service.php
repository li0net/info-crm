<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{

    protected $primaryKey = 'service_id';

    protected $fillable = [
        'name',
        'description',
        'price_min',
        'price_max',
        'duration'
    ];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_provides_service', 'service_id', 'employee_id')
                    ->withPivot('duration', 'routing_id');
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resources_attached_service', 'service_id', 'resource_id')
                    ->withPivot('amount');
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }


    /**
     * Возвращает свободные для записи интервалы времени у всех работников предоставляющих данную услугу
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

        // Определяем organization_id
        /*
        $orgId = DB::select(
            "SELECT sc.organization_id FROM service_categories sc JOIN services s ON sc.service_category_id = s.service_category_id WHERE s.service_id=?",
            [$this->service_id]
        );
        if (count($orgId) == 0) {
            // Error - no service category found
            return FALSE;
        }
        $orgId = $orgId[0]->organization_id;
        */

        // Отбираем интервалы расписаний в пределах нужного срока и Сортируем их по возрастанию
        $schedules = DB::select(
            "SELECT DISTINCT ".
            "(CASE WHEN work_start < '$startDateTime' THEN '$startDateTime' ELSE work_start END) AS work_start, ".
            "(CASE WHEN work_end > '$endDateTime' THEN '$endDateTime' ELSE work_end END) AS work_end, ".
            "s.employee_id ".
            "FROM schedules s ".
            "JOIN employee_provides_service eps ON s.employee_id=eps.employee_id ".
            "WHERE eps.service_id=? AND ".
            "( ".
                "(work_start >= '$startDateTime' AND work_end <= '$endDateTime')  OR ".
                "(work_start < '$startDateTime' AND work_end > '$startDateTime' AND work_end <= '$endDateTime') OR ".
                "(work_start >= '$startDateTime' AND work_start<'$endDateTime' AND work_end > '$endDateTime') OR ".
                "(work_start < '$startDateTime' AND work_end > '$endDateTime') ".
            ") ".
            "ORDER BY work_start ASC",
            [$this->service_id]
        );
        if (count($schedules) == 0) {
            return array();
        }

        // составляем список всех отобранных работников
        $employees = [];
        foreach ($schedules AS $schedule) {
            $employees[$schedule->employee_id] = 1;
        }
        $employees = array_keys($employees);

        // TODO: хорошо бы не давать создавать записи которые заканчиваются позже чем рабочий интервал работника
        // Отбираем записи в пределах того же срока и тоже Сортируем по возрастанию (по дате начала)
        $appts = DB::select(
            "SELECT ".
            "(CASE WHEN start < '$startDateTime' THEN '$startDateTime' ELSE start END) AS start, ".
            "(CASE WHEN `end` > '$endDateTime' THEN '$endDateTime' ELSE `end` END) AS `end` ".
            "FROM appointments ".
            "WHERE employee_id IN ('".implode("','", $employees)."') AND (start BETWEEN '$startDateTime' AND '$endDateTime') OR (end BETWEEN '$startDateTime' AND '$endDateTime') ".
            "ORDER BY start ASC",
            [$this->employee_id]
        );
        if (count($appts) == 0) {
            return $schedules;
        }

        $emp = new Employee();
        //В пхп в цикле проходим по массиву записей (appointments) и вызываем функцию X(массив интервалов расписаний, конкретная запись) которая вернет новый массив интервалов расписаний
        foreach($appts AS $apt) {
            $emp->subtractAppointmentsPeriodFromWorkSchedule($schedules, $apt);
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
     * Возвращает временные метки свободные для записи на выбранный день
     *
     * @param $day string 'YYYY-mm-dd'
     *
     * @return array|bool  ['10:30', '11:15', '14:00', '14:45']
     */
    public function getFreeWorkTimesForDay($day) {
        if (!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $day)) {
            return FALSE;
        }

        $ss = '00';
        list($sh, $sm, $ss) = explode(':', $this->duration);		//'00:45:00'
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
}

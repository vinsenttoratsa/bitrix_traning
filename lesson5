<?php

function generateSchedule($year, $month, $startDay = 1, $isWorkDay = true) {
    $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
    $schedule = [];
    $workDayCounter = 0;
    
    if ($startDay > 1) {
        $workDayCounter = $isWorkDay ? 0 : 1;
    } else {
        $workDayCounter = 0;
    }
    
    for ($day = $startDay; $day <= $daysInMonth; $day++) {
        $timestamp = mktime(0, 0, 0, $month, $day, $year);
        $dayOfWeek = date('N', $timestamp);
        
        $isWorkDay = false;
        
        if ($workDayCounter === 0) {
            if ($dayOfWeek >= 6) {
                $workDayCounter = 1;
            } else {
                $isWorkDay = true;
                $workDayCounter = 1;
            }
        } else {
            $workDayCounter++;
            if ($workDayCounter > 2) {
                $workDayCounter = 0;
            }
        }
        
        $schedule[$day] = [
            'is_work_day' => $isWorkDay,
            'day_of_week' => $dayOfWeek,
            'timestamp' => $timestamp
        ];
    }
    
    return [
        'schedule' => $schedule,
        'last_day_work_counter' => $workDayCounter,
        'is_last_day_work' => ($workDayCounter === 0)
    ];
}

function displayMonthSchedule($year, $month, $startDay = 1, $isStartWorkDay = true) {
    $monthNames = [
        1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
        5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
        9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
    ];
    
    $result = generateSchedule($year, $month, $startDay, $isStartWorkDay);
    $schedule = $result['schedule'];
    
    echo "\n\033[1;34m" . $monthNames[$month] . " " . $year . "\033[0m\n";
    echo "=================================\n";
    
    foreach ($schedule as $day => $info) {
        $dayOfWeekNames = [
            1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 
            5 => 'Пт', 6 => 'Сб', 7 => 'Вс'
        ];
        
        $dayDisplay = str_pad($day, 2, ' ', STR_PAD_LEFT);
        $dayOfWeek = $dayOfWeekNames[$info['day_of_week']];
        
        if ($info['is_work_day']) {
            echo "\033[32m" . $dayDisplay . " " . $dayOfWeek . " (+)\033[0m ";
        } else {
            if ($info['day_of_week'] >= 6) {
                echo "\033[31m" . $dayDisplay . " " . $dayOfWeek . "\033[0m     ";
            } else {
                echo $dayDisplay . " " . $dayOfWeek . "      ";
            }
        }
        
        if ($info['day_of_week'] == 7) {
            echo "\n";
        }
    }
    echo "\n";
    
    $workDays = array_filter($schedule, function($day) {
        return $day['is_work_day'];
    });
    
    echo "Рабочих дней: " . count($workDays) . "\n";
    echo "=================================\n";
    
    return $result;
}

function readInput($prompt, $validation = null) {
    echo $prompt;
    $input = trim(fgets(STDIN));
    
    if ($validation) {
        while (!$validation($input)) {
            echo "Неверный ввод. Попробуйте еще раз: ";
            $input = trim(fgets(STDIN));
        }
    }
    
    return $input;
}

if (php_sapi_name() === 'cli') {
    
    echo "=================================\n";
    echo "Генератор расписания работы\n";
    echo "Режим: сутки через двое\n";
    echo "=================================\n\n";
    
    $year = readInput("Введите год (1970-2038): ", function($input) {
        return is_numeric($input) && $input >= 1970 && $input <= 2038;
    });
    $year = (int)$year;
    
    $month = readInput("Введите месяц (1-12): ", function($input) {
        return is_numeric($input) && $input >= 1 && $input <= 12;
    });
    $month = (int)$month;
    
    $monthsCount = readInput("Введите количество месяцев для расчета (1-12): ", function($input) {
        return is_numeric($input) && $input >= 1 && $input <= 12;
    });
    $monthsCount = (int)$monthsCount;
    
    echo "\n";
    echo "Расчет графика для:\n";
    echo "Год: " . $year . "\n";
    echo "Месяц: " . $month . "\n";
    echo "Количество месяцев: " . $monthsCount . "\n";
    echo "=================================\n";
    
    $currentYear = $year;
    $currentMonth = $month;
    $startDay = 1;
    $isStartWorkDay = true;
    
    for ($i = 0; $i < $monthsCount; $i++) {
        $result = displayMonthSchedule($currentYear, $currentMonth, $startDay, $isStartWorkDay);
        
        $currentMonth++;
        if ($currentMonth > 12) {
            $currentMonth = 1;
            $currentYear++;
        }
        $startDay = 1;
        $isStartWorkDay = $result['is_last_day_work'];
    }
    
    echo "\n";
    $repeat = readInput("Хотите выполнить еще один расчет? (y/n): ", function($input) {
        return in_array(strtolower($input), ['y', 'n', 'д', 'н', 'yes', 'no', 'да', 'нет']);
    });
    
    if (in_array(strtolower($repeat), ['y', 'д', 'yes', 'да'])) {
        $cmd = "php " . __FILE__;
        system($cmd);
    } else {
        echo "Спасибо за использование программы!\n";
    }
    
} else {
    echo "<pre>";
    echo "Эта программа предназначена для запуска в командной строке.\n";
    echo "Откройте терминал и выполните: php " . basename(__FILE__) . "\n";
    echo "</pre>";
}

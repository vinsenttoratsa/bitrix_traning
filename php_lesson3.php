<?php
echo "Введите имя: ";
$name = trim(fgets(STDIN));

echo "Введите фамилию: ";
$surname = trim(fgets(STDIN));

echo "Введите отчество: ";
$patronymic = trim(fgets(STDIN));


function capitalize($str) {
    if (empty($str)) return $str;

    $firstChar = mb_strtoupper(mb_substr($str, 0, 1));
    $rest = mb_strtolower(mb_substr($str, 1));
    
    return $firstChar . $rest;
}


$fullName = capitalize($surname) . ' ' . capitalize($name) . ' ' . capitalize($patronymic);


$surnameAndInitials = capitalize($surname) . ' ' . 
                      mb_strtoupper(mb_substr($name, 0, 1)) . '.' . 
                      mb_strtoupper(mb_substr($patronymic, 0, 1)) . '.';


$fio = mb_strtoupper(mb_substr($surname, 0, 1)) . 
       mb_strtoupper(mb_substr($name, 0, 1)) . 
       mb_strtoupper(mb_substr($patronymic, 0, 1));


echo "Полное имя: '" . $fullName . "'\n";
echo "Фамилия и инициалы: '" . $surnameAndInitials . "'\n";
echo "Аббревиатура: '" . $fio . "'\n";

<?php
while (true) {
    echo "Введите число №1: ";
    $number1 = trim(fgets(STDIN));
    
    if (is_numeric($number1)) {
        break;
    }
    fwrite(STDERR, "Ошибка: введите число!\n");
}

while (true) {
    echo "Введите число №2: ";
    $number2 = trim(fgets(STDIN));
    
    if (!is_numeric($number2)) {
        fwrite(STDERR, "Ошибка: введите число!\n");
        continue;
    }
    
    if ((int)$number2 == 0) {
        fwrite(STDERR, "Ошибка: делить на 0 нельзя!\n");
        continue;
    }
    
    break;
}

$number1 = (int)$number1;
$number2 = (int)$number2;
fwrite(STDOUT, "Ответ: " . ($number1 / $number2) . "\n");
<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4;
const OPERATION_QUANTITY = 5;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Изменить название товара.',
    OPERATION_QUANTITY => OPERATION_QUANTITY . '. Изменить количество товара.',
];

$items = [];

function clearScreen(): void
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

function displayItemsAndGetOperation(array $items, array $operations): int
{
    displayItems($items);

    $availableOperations = $operations;
    if (empty($items)) {
        unset($availableOperations[OPERATION_DELETE], $availableOperations[OPERATION_EDIT], $availableOperations[OPERATION_QUANTITY]);
    }

    echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    echo implode(PHP_EOL, $availableOperations) . PHP_EOL . '> ';
    
    return (int)trim(fgets(STDIN));
}

function displayItems(array $items): void
{
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        foreach ($items as $index => $item) {
            $quantity = isset($item['quantity']) ? " ({$item['quantity']} шт.)" : '';
            echo ($index + 1) . ". {$item['name']}{$quantity}" . PHP_EOL;
        }
        echo PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL . PHP_EOL;
    }
}

function addItem(array $items): array
{
    echo "Введите название товара: \n> ";
    $itemName = trim(fgets(STDIN));
    
    if (empty($itemName)) {
        echo 'Название товара не может быть пустым.' . PHP_EOL;
        return $items;
    }
    
    echo "Введите количество: \n> ";
    $quantity = (int)trim(fgets(STDIN));
    
    $items[] = [
        'name' => $itemName,
        'quantity' => $quantity > 0 ? $quantity : 1
    ];
    
    echo "Товар '{$itemName}' добавлен в список." . PHP_EOL;
    return $items;
}

function deleteItem(array $items): array
{
    displayItems($items);
    
    if (empty($items)) {
        echo 'Нет товаров для удаления.' . PHP_EOL;
        return $items;
    }
    
    echo 'Введите номер товара для удаления:' . PHP_EOL . '> ';
    $itemNumber = (int)trim(fgets(STDIN)) - 1;
    
    if (isset($items[$itemNumber])) {
        $itemName = $items[$itemNumber]['name'];
        unset($items[$itemNumber]);
        $items = array_values($items);
        echo "Товар '{$itemName}' удален из списка." . PHP_EOL;
    } else {
        echo 'Товар с таким номером не найден.' . PHP_EOL;
    }
    
    return $items;
}

function editItem(array $items): array
{
    displayItems($items);
    
    if (empty($items)) {
        echo 'Нет товаров для редактирования.' . PHP_EOL;
        return $items;
    }
    
    echo 'Введите номер товара для изменения:' . PHP_EOL . '> ';
    $itemNumber = (int)trim(fgets(STDIN)) - 1;
    
    if (isset($items[$itemNumber])) {
        echo "Введите новое название для товара '{$items[$itemNumber]['name']}':" . PHP_EOL . '> ';
        $newName = trim(fgets(STDIN));
        
        if (empty($newName)) {
            echo 'Название товара не может быть пустым.' . PHP_EOL;
            return $items;
        }
        
        $oldName = $items[$itemNumber]['name'];
        $items[$itemNumber]['name'] = $newName;
        
        echo "Товар '{$oldName}' переименован в '{$newName}'." . PHP_EOL;
    } else {
        echo 'Товар с таким номером не найден.' . PHP_EOL;
    }
    
    return $items;
}

function changeQuantity(array $items): array
{
    displayItems($items);
    
    if (empty($items)) {
        echo 'Нет товаров для изменения количества.' . PHP_EOL;
        return $items;
    }
    
    echo 'Введите номер товара для изменения количества:' . PHP_EOL . '> ';
    $itemNumber = (int)trim(fgets(STDIN)) - 1;
    
    if (isset($items[$itemNumber])) {
        $currentQuantity = $items[$itemNumber]['quantity'] ?? 1;
        echo "Текущее количество товара '{$items[$itemNumber]['name']}': {$currentQuantity}" . PHP_EOL;
        echo "Введите новое количество:" . PHP_EOL . '> ';
        
        $newQuantity = (int)trim(fgets(STDIN));
        if ($newQuantity > 0) {
            $items[$itemNumber]['quantity'] = $newQuantity;
            echo "Количество товара '{$items[$itemNumber]['name']}' изменено на {$newQuantity}." . PHP_EOL;
        } else {
            echo 'Количество должно быть положительным числом.' . PHP_EOL;
        }
    } else {
        echo 'Товар с таким номером не найден.' . PHP_EOL;
    }
    
    return $items;
}

function printItems(array $items): void
{
    displayItems($items);
    
    $totalItems = count($items);
    $totalQuantity = array_sum(array_column($items, 'quantity'));
    
    echo "Всего {$totalItems} позиций, {$totalQuantity} шт." . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function isValidOperation(int $operation, array $operations): bool
{
    return array_key_exists($operation, $operations);
}

function waitForEnter(): void
{
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

do {
    clearScreen();

    $operationNumber = displayItemsAndGetOperation($items, $operations);

    if (!isValidOperation($operationNumber, $operations)) {
        clearScreen();
        echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL . PHP_EOL;
        waitForEnter();
        continue;
    }

    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL . PHP_EOL;

    $needWait = true;
    switch ($operationNumber) {
        case OPERATION_ADD:
            $items = addItem($items);
            break;

        case OPERATION_DELETE:
            $items = deleteItem($items);
            break;
            
        case OPERATION_EDIT:
            $items = editItem($items);
            break;
            
        case OPERATION_QUANTITY:
            $items = changeQuantity($items);
            break;

        case OPERATION_PRINT:
            printItems($items);
            $needWait = false;
            break;
    }

    if ($operationNumber !== OPERATION_EXIT) {
        if ($needWait) {
            echo "\n ----- \n";
            waitForEnter();
        }
    }
} while ($operationNumber > 0);

clearScreen();
echo 'Программа завершена' . PHP_EOL;
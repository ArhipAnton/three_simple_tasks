<?php

class ArrayHelper
{
    private static array $usedItems = [];

    public static function buildUniqueArray(int $columnsCount, int $rowsCount, int $minItem, int $maxItem): array
    {
        if (($maxItem - $minItem) < $columnsCount * $rowsCount) {
            throw new LogicException(
                'It is not possible to create an array of unique numbers with such parameters'
            );
        }

        self::$usedItems = [];
        $rows = [];

        for ($i = 0; $i < $rowsCount; $i++) {
            $row = [];
            for ($j = 0; $j < $columnsCount; $j++) {
                $row[] = self::generateUnique($minItem, $maxItem);
            }
            $rows[] = $row;
        }
        return $rows;
    }

    private static function generateUnique(int $min, int $max): int
    {
        $rand = rand($min, $max);
        if (!array_search($rand, self::$usedItems)) {
            self::$usedItems[] = $rand;
            return $rand;
        }
        return self::generateUnique($min, $max);
    }

    public static function showArrayAndSum(array $array): void
    {
        $columns = [];
        foreach ($array as $row) {
            foreach ($row as $columnNum => $item) {
                echo $item . ' ';
                $columns[$columnNum][] = $item;
            }
            echo ' | sum=' . array_sum($row);
            echo PHP_EOL;
        }

        echo '--- columns sum ---';
        echo PHP_EOL;

        foreach ($columns as $column) {
            echo array_sum($column) . ' ';
        }
    }
}

$array = ArrayHelper::buildUniqueArray(5, 7, 1, 1000);
ArrayHelper::showArrayAndSum($array);
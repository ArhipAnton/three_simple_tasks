<?php

class ArrayHelper
{
    private static array $usedItems;
    private const CRITERION = 1000;

    /**
     * @throws InvalidArgumentException
     */
    public static function printArray(int $colCount, int $rowCount, int $min, int $max): void
    {
        self::validate($colCount, $rowCount, $min, $max);
        $array = self::generateArray($colCount, $rowCount, $min, $max);
        self::print($array);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function validate(int $colCount, int $rowCount, int $min, int $max): void
    {
        if ($colCount <= 0 || $rowCount <= 0) {
            throw new InvalidArgumentException('columns and rows count must be greater than zero');
        }
        if (($max - $min) < ($colCount * $rowCount)) {
            throw new InvalidArgumentException('The array value range must be greater than the array size');
        }
    }

    public static function generateArray(int $colCount, int $rowCount, int $min, int $max): array
    {
        $size = $colCount * $rowCount;
        $div = ($max - $min) / ($colCount * $rowCount);

        if ($div < self::CRITERION) {
            $array = self::generateAlg1($min, $max, $size);
        } else {
            $array = self::generateAlg2($min, $max, $size);
        }

        return array_chunk($array, $colCount);
    }

    private static function generateAlg1(int $min, int $max, int $size): array
    {
        $array = range($min, $max);
        shuffle($array);
        return array_slice($array, 0, $size);
    }

    private static function generateAlg2(int $min, int $max, int $size): array
    {
        $array = [];
        while (count($array) < $size) {
            $randomNumber = rand($min, $max);

            if (!in_array($randomNumber, $array)) {
                $array[] = $randomNumber;
            }
        }
        return $array;
    }

    private static function print(array $array): void
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

ArrayHelper::printArray(5, 7, 1, 1000);

`<?php

$number = 1;
$rowCount = 1;
$limit = 100;
while ($number <= $limit) {
    for ($i = 0; $i < $rowCount && $number <= $limit; $i++) {
        echo $number++ . ' ';
    }
    echo PHP_EOL;
    $rowCount++;
}

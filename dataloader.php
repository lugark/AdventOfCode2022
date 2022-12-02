<?php

function loadDay2Data()
{
    $data = [];
    $f = fopen('data/day2.txt', 'r');
    while ($row = fgetcsv($f, null, " ")) {
        $data[] = $row;
    }
    return $data;
}
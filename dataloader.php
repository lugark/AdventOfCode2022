<?php

function loadAsCSV($file, $separator): array
{
    $data = [];
    $f = fopen($file, 'r');
    while ($row = fgetcsv($f, null, $separator)) {
        $data[] = $row;
    }
    return $data;
}

function loadDay2Data()
{
    $data = [];
    $f = fopen('data/day2.txt', 'r');
    while ($row = fgetcsv($f, null, " ")) {
        $data[] = $row;
    }
    return $data;
}

function loadDay3Data()
{
    $data = [];
    $f = fopen('data/day3.txt', 'r');
    while ($row = fgets($f)) {
        $data[] = trim($row);
    }
    return $data;
}

function loadDay4Data()
{
    return loadAsCSV('data/day4.txt', ',');
}
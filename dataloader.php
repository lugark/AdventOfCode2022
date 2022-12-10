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

function loadAsText($file): array{
    $data = [];
    $f = fopen($file, 'r');
    while ($row = fgets($f)) {
        $data[] = trim($row);
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

function loadDay5Data()
{
    /**
     *
     * [T]     [D]         [L]
     * [R]     [S] [G]     [P]         [H]
     * [G]     [H] [W]     [R] [L]     [P]
     * [W]     [G] [F] [H] [S] [M]     [L]
     * [Q]     [V] [B] [J] [H] [N] [R] [N]
     * [M] [R] [R] [P] [M] [T] [H] [Q] [C]
     * [F] [F] [Z] [H] [S] [Z] [T] [D] [S]
     * [P] [H] [P] [Q] [P] [M] [P] [F] [D]
     *  1   2   3   4   5   6   7   8   9
     */
    $schema = ["[T]     [D]         [L]            ",
               "[R]     [S] [G]     [P]         [H]",
               "[G]     [H] [W]     [R] [L]     [P]",
               "[W]     [G] [F] [H] [S] [M]     [L]",
               "[Q]     [V] [B] [J] [H] [N] [R] [N]",
               "[M] [R] [R] [P] [M] [T] [H] [Q] [C]",
               "[F] [F] [Z] [H] [S] [Z] [T] [D] [S]",
               "[P] [H] [P] [Q] [P] [M] [P] [F] [D]"];

    $crates = [[],[],[],[],[],[],[],[],[]];
    foreach ($schema as $row) {
        for ($i=0; $i<9; $i++) {
            if ($row[($i*4)+1] !== " ") {
                array_unshift($crates[$i], $row[($i*4)+1]);
            }
        }
    }

    return [
        'moves' => loadAsText('data/day5.txt'),
        'crates' => $crates
    ];
}

function loadDay7Data()
{
    return loadAsText('data/day7.txt');
}

function loadDay8Data()
{
    $data = [];
    foreach (loadAsText('data/day8.txt') as $line) {
        $data[] = str_split(trim($line));
    }
    return $data;
}

function loadDay10Data()
{
    return loadAsText('data/day10.txt');
}
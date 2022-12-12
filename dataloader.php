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

function loadDay9Data()
{
    return loadAsText("data/day9.txt");
}

function loadDay10Data()
{
    return loadAsText('data/day10.txt');
}

function loadDay11Data()
{
    return [
        [ 'Monkey 0:', 'Starting items: 56, 56, 92, 65, 71, 61, 79', 'Operation: new = old * 7', 'Test: divisible by 3', 'If true: throw to monkey 3', 'If false: throw to monkey 7'],
        [ 'Monkey 1:', 'Starting items: 61, 85', 'Operation: new = old + 5', 'Test: divisible by 11', 'If true: throw to monkey 6', 'If false: throw to monkey 4'],
        [ 'Monkey 2:', 'Starting items: 54, 96, 82, 78, 69', 'Operation: new = old * old', 'Test: divisible by 7', 'If true: throw to monkey 0', 'If false: throw to monkey 7'],
        [ 'Monkey 3:', 'Starting items: 57, 59, 65, 95', 'Operation: new = old + 4', 'Test: divisible by 2', 'If true: throw to monkey 5', 'If false: throw to monkey 1'],
        [ 'Monkey 4:', 'Starting items: 62, 67, 80', 'Operation: new = old * 17', 'Test: divisible by 19', 'If true: throw to monkey 2', 'If false: throw to monkey 6'],
        [ 'Monkey 5:', 'Starting items: 91', 'Operation: new = old + 7', 'Test: divisible by 5', 'If true: throw to monkey 1', 'If false: throw to monkey 4'],
        [ 'Monkey 6:', 'Starting items: 79, 83, 64, 52, 77, 56, 63, 92', 'Operation: new = old + 6', 'Test: divisible by 17', 'If true: throw to monkey 2', 'If false: throw to monkey 0'],
        [ 'Monkey 7:', 'Starting items: 50, 97, 76, 96, 80, 56', 'Operation: new = old + 3', 'Test: divisible by 13', 'If true: throw to monkey 3', 'If false: throw to monkey 5']
    ];
}

<?php
require_once "dataloader.php";

/** Example data */
$crates = [
    ['Z', 'N'],
    ['M', 'C', 'D'],
    ['P']
];

$movements = [
'move 1 from 2 to 1',
'move 3 from 1 to 3',
'move 2 from 2 to 1',
'move 1 from 1 to 2',
];

function moveCrates9000($assignments, $crates): array
{
    $split = explode(' ' , $assignments);
    $count = $split[1];
    $from = $split[3];
    $to = $split[5];

    for ($i=0; $i<$count; $i++) {
        array_push($crates[$to-1], array_pop($crates[$from-1]));
    }
    return $crates;
}

function moveCrates9001($assignments, $crates): array
{
    $split = explode(' ' , $assignments);
    
    $from = $split[3]-1;
    $to = $split[5]-1;
    $position = count($crates[$from]) - $split[1];

    $movedCrates = array_splice($crates[$from], $position);
    $crates[$to] = array_merge($crates[$to], $movedCrates);

    return $crates;
}


/******** Part One **********/
$data = loadDay5Data();
$cratesResult = $data['crates'];
foreach ($data['moves'] as $rearrange) {
    $cratesResult = moveCrates9000($rearrange, $cratesResult);
}

$topCrates = '';
foreach ($cratesResult as $pile) {
    $topCrates .= array_pop($pile);
}
var_dump($topCrates);

/******** Part Two **********/
$data = loadDay5Data();
$cratesResult = $data['crates'];
foreach ($data['moves'] as $rearrange) {
    $cratesResult = moveCrates9001($rearrange, $cratesResult);
}
$topCrates = '';
foreach ($cratesResult as $pile) {
    $topCrates .= array_pop($pile);
}
var_dump($topCrates);
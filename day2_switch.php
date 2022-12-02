<?php
require_once "dataloader.php";

function getMyScore($a, $b): int
{
    if ($a == $b) {
        return 3;
    }

    switch ($a) {
        case 1: 
            return $b == 2 ? 6 : 0;
            break;
        case 2: 
            return $b == 3 ? 6 : 0;
            break;
        case 3: 
            return $b == 1 ? 6 : 0;
            break;
    }  
}

$input = loadDay2Data();
$score = 0;
foreach ($input as $match) {
    $opp = ord($match[0]) - 64;
    $mine = ord($match[1]) - 87;

    $score += getMyScore($opp, $mine) + $mine;
}
var_dump($score);
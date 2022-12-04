<?php
require_once "dataloader.php";

/** Testinput - 2 paris completely overlap */
$input = [
['2-4','6-8'],
['2-3','4-5'],
['5-7','7-9'],
['2-8','3-7'],
['6-6','4-6'],
['2-6','4-8']];

$input = loadDay4Data();

function isIncluded($first, $second): bool
{
    list($firstLeft, $firstRight) = explode('-',$first);
    list($secondLeft, $secondRight) = explode('-',$second);
    if (($firstLeft<=$secondLeft && $secondRight<=$firstRight) ||
    ($secondLeft<=$firstLeft && $firstRight<=$secondRight)) {
        return true;
    }

    return false;
}

function hasOverlapings($first, $second): bool
{
    list($firstLeft, $firstRight) = explode('-',$first);
    list($secondLeft, $secondRight) = explode('-',$second);
    if (($firstLeft<=$secondLeft && $secondLeft<=$firstRight) ||
     ($firstLeft<=$secondRight && $secondRight<=$firstRight)) {
        return true;
    }
    if (($secondLeft<=$firstLeft && $firstLeft<=$secondRight)) {
        return true;
    }
    return false;
}


$overlappings = 0;
foreach ($input as $sectionList) {
    $overlappings += isIncluded($sectionList[0], $sectionList[1]) ? 1 : 0;
}

var_dump($overlappings);


$overlappings = 0;
foreach ($input as $sectionList) {
    $overlappings += hasOverlapings($sectionList[0], $sectionList[1]) ? 1 : 0;
}

var_dump($overlappings);
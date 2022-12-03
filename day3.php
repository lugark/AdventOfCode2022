<?php
require "dataloader.php";

/** Testinput - result = 157 */
$input = [
'vJrwpWtwJgWrhcsFMMfFFhFp',
'jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL',
'PmmdzqPrVvPwwTWBwg',
'wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn',
'ttgJtRGJQctTZtZT',
'CrZsJsPPZsGzwwsLwLmpwMDw',
];


$input = loadDay3Data();
$priority = 0;
foreach ($input as $line) {
    $middle = strlen($line)/2;
    $left = str_split(substr($line, 0, $middle));
    $right = str_split(substr($line, $middle));
    $inboth = array_intersect($left, $right);
    if (!empty($inboth)) {
        $ord = ord(array_pop($inboth));
        $priority += $ord > 90 ? $ord - 96 : $ord - 38;
    }
}
var_dump($priority);

$group = [];
$badgeSum = 0;
foreach ($input as $key => $line) {
    $group[] = str_split($line);
    if (($key+1) % 3 === 0) {
        $inAll = array_intersect($group[0], $group[1], $group[2]);
        if (!empty($inAll)) {
            $ord = ord(array_pop($inAll));
            $badgeSum += $ord > 90 ? $ord - 96 : $ord - 38;
        }
        $group = [];        
    }
}
var_dump($badgeSum);
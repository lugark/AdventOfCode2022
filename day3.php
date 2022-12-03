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
<?php
require_once "dataloader.php";

class X 
{
    public $selfValue = 1;
    public function getScore($choiceOpponent): int
    {
        if ($choiceOpponent == 'A') {
            return 3;
        } elseif ($choiceOpponent == 'B') {
            return 0;
        }
        return 6;        
    }
}

class Y
{
    public $selfValue = 2;
    public function getScore($choiceOpponent): int
    {
        if ($choiceOpponent == 'A') {
            return 6;
        } elseif ($choiceOpponent == 'B') {
            return 3;
        }
        return 0;        
    }
}

class Z
{
    public $selfValue = 3;
    public function getScore($choiceOpponent): int
    {
        if ($choiceOpponent == 'A') {
            return 0;
        } elseif ($choiceOpponent == 'B') {
            return 6;
        }
        return 3;        
    }
}

$decider['X'] = new X();
$decider['Y'] = new Y();
$decider['Z'] = new Z();

$input = loadDay2Data();
$score = 0;
foreach ($input as $match) {
    $score += $decider[$match[1]]->getScore($match[0]);
    $score += $decider[$match[1]]->selfValue;
}
var_dump($score);
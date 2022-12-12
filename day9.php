<?php
require_once "dataloader.php";
class Tail
{
    public $x=0;
    public $y=4;
    public $visited = ['0-4'];

    public function follow($x, $y)
    {
        $distanceX = $x - $this->x;
        $distanceY = $y - $this->y;

        if ($distanceX == 0 && $distanceY == 0) return;
        if (
            (abs($distanceX) == 1 && abs($distanceY) == 1) ||
            (abs($distanceX) == 1 && $distanceY == 0) ||
            (abs($distanceY) == 1 && $distanceX == 0)
        ) return;

        if ($distanceX != 0) {
            $this->x += $distanceX>0 ? 1 : -1;
        }
        if ($distanceY != 0) {
            $this->y += $distanceY>0 ? 1 : -1;
        }

        $position = $x.'-'.$y;
        if (!in_array($position, $this->visited)) $this->visited[]= $position;
    }
}

class Head
{
    private $x=0;
    private $y=4;

    private $moveDir='';
    private $steps=0;
    private Tail $tail;

    public function __construct(Tail $tail)
    {
        $this->tail = $tail;
    }

    public function moveHead($command)
    {
        echo $command . PHP_EOL;
        $parsed = explode(" ", $command);
        $this->moveDir = $parsed[0];
        $this->steps = $parsed[1];
    }

    public function go()
    {
        if ($this->steps == 0 && empty($this->moveDir)) return false;

        switch ($this->moveDir) {
            case 'R':
                $this->x++;
                break;
            case 'U':
                $this->y--;
                break;
            case 'L':
                $this->x--;
                break;
            case 'D':
                $this->y++;
                break;
        }
        $this->steps--;
        $this->tail->follow($this->x, $this->y);
        if ($this->steps == 0) {
            $this->moveDir = '';
        }
        #$this->draw();
        return $this->steps != 0;
    }

    public function draw()
    {
        $field = [];
        for ($i=0; $i<5; $i++) {
            $field[] = array_fill(0,6, '.');
        }
        $field[$this->tail->y][$this->tail->x] = 'T';
        $field[$this->y][$this->x] = 'H';
        foreach ($field as $row) {
            foreach ($row as $cell) {
                echo $cell;
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}

$input = ['R 4', 'U 4', 'L 3', 'D 1', 'R 4', 'D 1', 'L 5', 'R 2'];
$input = loadDay9Data();
$tail = new Tail();
$head = new Head($tail);
$commandPosition = 0;
foreach ($input as $command) {
    $head->moveHead($command);
    while ($head->go()) {
        $head->draw();
    }
    $head->draw();
}
var_dump($tail->visited);

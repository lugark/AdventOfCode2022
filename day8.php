<?php
require_once "dataloader.php";

class Node
{
    public ?Node $gt = null;
    public ?Node $lte = null;
    public int $height;
    public string $position;

    public function __construct($height, $position)
    {
        $this->height = $height;
        $this->position = $position;
    }

    public function getVisibles($visibles)
    {
        if (!in_array($this->position, $visibles)) {
            $visibles[] = $this->position;
        }
        return $this->gt ? $this->gt->getVisibles($visibles) : $visibles;
    }

    public function countVisibiles($count)
    {
        return $this->gt ? $this->gt->countVisibiles($count+1) : $count;
    }

    public function addNode($height, $position)
    {
        if ($this->height < $height) {
            if ($this->gt) {
                $this->gt->addNode($height,$position);
            } else {
                $this->gt = new Node($height, $position);
            }
        } else {
            if ($this->lte) {
                $this->lte->addNode($height, $position);
            } else {
                $this->lte = new Node($height,$position);
            }
        }
    }
}

class Tree
{
    private $row;
    private $column;
    private $height;
    public $x;
    public $y;

    public function __construct($map, $x, $y)
    {
        $this->row = $map[$y];
        foreach ($map as $row) {
            $this->column[] = $row[$x];
        }
        $this->height = $map[$y][$x];
        $this->x = $x;
        $this->y = $y;
    }

    public function canBeSeen()
    {
        $seenLeft = true;
        $seenRight = true;
        $seenTop = true;
        $seenBottom = true;
        $maxCol = count($this->column);
        $maxRow = count($this->row);
        if ($this->x == 0 || $this->y == 0 || $this->x == $maxCol || $this->y == $maxRow) {
            return true;
        }

        for ($i=$this->x-1; $i>=0; $i--) {
            $seenLeft = $this->height > $this->row[$i];
            if (!$seenLeft) break;
        }
        for ($i=$this->x+1; $i<count($this->row); $i++) {
            $seenRight = $this->height > $this->row[$i];
            if (!$seenRight) break;
        }
        for ($i=$this->y-1; $i>=0; $i--) {
            $seenTop = $this->height > $this->column[$i];
            if (!$seenTop) break;
        }
        for ($i=$this->y+1; $i<count($this->column); $i++) {
            $seenBottom = $this->height > $this->column[$i];
            if (!$seenBottom) break;
        }

        return $seenRight || $seenLeft || $seenTop || $seenBottom;
    }

    public function getScenicScore()
    {

    }
}


$input = [
    [3,0,3,7,3],
    [2,5,5,1,2],
    [6,5,3,3,2],
    [3,3,5,4,9],
    [3,5,3,9,0],
];

function getLeftViewTrees($input, $visibleTrees)
{
    for ($x=0; $x<count($input); $x++) {
        $node = new Node($input[$x][0], $x.'-0');
        for ($y=1; $y<count($input[$x]); $y++) {
            $node->addNode($input[$x][$y], $x.'-'.$y);
        }
        $visibleTrees = $node->getVisibles($visibleTrees);
    }
    return $visibleTrees;
}

function getTopViewTrees($input, $visibleTrees)
{
    for ($j=0; $j<count($input[0]); $j++) {
        $node = new Node($input[0][$j], '0-'.$j);
        for ($i=1; $i<count($input); $i++) {
            $node->addNode($input[$i][$j], $i.'-'.$j);
        }
        $visibleTrees = $node->getVisibles($visibleTrees);
    }
    return $visibleTrees;
}

function getRightViewTrees($input, $visibleTrees)
{
    for ($x=0; $x<count($input); $x++) {
        $lastRowNum = count($input[0])-1;
        $node = new Node($input[$x][$lastRowNum], $x.'-'.$lastRowNum);
        for ($y=$lastRowNum-1; $y>=0; $y--) {
            $node->addNode($input[$x][$y], $x.'-'.$y);
        }
        $visibleTrees = $node->getVisibles($visibleTrees);
    }
    return $visibleTrees;
}

function getBottomViewTrees($input, $visibleTrees)
{
    for ($j=0; $j<count($input[0]); $j++) {
        $lastRowNum = count($input)-1;
        $node = new Node($input[$lastRowNum][$j], $lastRowNum.'-'.$j);
        for ($i=$lastRowNum-1; $i>=0; $i--) {
            $node->addNode($input[$i][$j], $i.'-'.$j);
        }
        $visibleTrees = $node->getVisibles($visibleTrees);
    }
    return $visibleTrees;
}

$input = loadDay8Data();
$visibleTrees = getLeftViewTrees($input, []);
$visibleTrees = getTopViewTrees($input, $visibleTrees);
$visibleTrees = getRightViewTrees($input, $visibleTrees);
$visibleTrees = getBottomViewTrees($input, $visibleTrees);
var_dump(count($visibleTrees));

$trees = [];
foreach ($input as $y=>$row) {
    foreach ($row as $x=>$cell) {
        $trees[]= new Tree($input, $x, $y);
    }
}
$visibleTrees = 0;
foreach ($trees as $tree) {
    $visibleTrees += $tree->canBeSeen() ? 1 : 0;
}
var_dump($visibleTrees);

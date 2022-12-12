<?php
require_once "dataloader.php";
class Monkey
{
    private $items;
    private $number;
    private $operation;
    private $testDivisible;
    private $monkeyTestTrue;
    private $monkeyTestFalse;
    private $inspectedCount = 0;

    public function __construct($definition)
    {
        $parsedLines = [];
        foreach ($definition as $line) {
            $parsedLines[] = explode(" " , $line);
        }
        $this->number = str_replace(':', '', $parsedLines[0][1]);
        $this->items = explode(',', substr(str_replace(' ', '', $definition[1]),14));
        $this->operation = str_replace(['new', 'old'], ['$new', '$old'], substr($definition[2], 11, strlen($definition[2])-11)) . ';';
        $this->testDivisible = intval($parsedLines[3][3]);
        $this->monkeyTestTrue = $parsedLines[4][5];
        $this->monkeyTestFalse = $parsedLines[5][5];
    }

    public function passTo($worryLevel): int
    {
        return $worryLevel % $this->testDivisible == 0 ? $this->monkeyTestTrue : $this->monkeyTestFalse;
    }

    public function inspectItem(): int
    {
        $old = array_shift($this->items);
        $new = 0;
        eval($this->operation);
        $this->inspectedCount++;
        return floor($new / 3);
    }

    public function getNumber()
    {
        return intval($this->number);
    }

    public function catchItem($worryLevel)
    {
        $this->items[] = $worryLevel;
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }

    public function draw()
    {
        echo "Monkey ".$this->number.": ".implode(', ', $this->items).
             " (inspected items ".$this->inspectedCount." times)"
            .PHP_EOL;
    }

    public function getInspectedCount(): int
    {
        return $this->inspectedCount;
    }
}



$definition1 = [
    ['Monkey 0:','Starting items: 79, 98','Operation: new = old * 19','Test: divisible by 23','If true: throw to monkey 2','If false: throw to monkey 3'],
    ['Monkey 1:', 'Starting items: 54, 65, 75, 74', 'Operation: new = old + 6', 'Test: divisible by 19', 'If true: throw to monkey 2', 'If false: throw to monkey 0'],
    ['Monkey 2:', 'Starting items: 79, 60, 97', 'Operation: new = old * old', 'Test: divisible by 13', 'If true: throw to monkey 1', 'If false: throw to monkey 3', ''],
    ['Monkey 3:', 'Starting items: 74', 'Operation: new = old + 3', 'Test: divisible by 17', 'If true: throw to monkey 0', 'If false: throw to monkey 1']];
$definition1 = loadDay11Data();
$monkeys = [];
foreach ($definition1 as $definition) {
    $monkey = new Monkey($definition);
    $monkeys[$monkey->getNumber()] = $monkey;
}

for ($i=1; $i<=20; $i++) {
    foreach ($monkeys as $monkey) {
        while ($monkey->hasItems()) {
            $worryLevel = $monkey->inspectItem();
            $passTo = $monkey->passTo($worryLevel);
            $monkeys[$passTo]->catchItem($worryLevel);
        }
    }
    echo PHP_EOL."Round ".$i.PHP_EOL;
    $monkeyBusiness = [];
    foreach ($monkeys as $monkey) {
        $monkeyBusiness[] = $monkey->getInspectedCount();
        $monkey->draw();
    }
}
asort($monkeyBusiness);
$first = array_pop($monkeyBusiness);
$second = array_pop($monkeyBusiness);
var_dump($first*$second);

<?php
require_once "dataloader.php";

class Cpu
{
    public $registerX = 1;
    public $cycles = 0;
    private $signalStrength = 0;
    private $executionCounter = 0;
    private $command = [];

    public function cycle()
    {
        $this->cycles++;        
        $this->signalStrength = $this->cycles * $this->registerX;
        if ($this->executionCounter>0) $this->executionCounter--;
        if ($this->executionCounter == 0 && !empty($this->command)) {
            $this->registerX += $this->command[1];
            $this->command = [];            
        }   
    }

    public function isBusy()
    {
        return $this->executionCounter>0;
    }

    public function process($command) 
    {
        $parsedCommand = explode(" ", $command);
        if (count($parsedCommand)==0 || !in_array($parsedCommand[0], ['addx', 'noop'])) {
            throw new Exception($command . " not supported");
        }


        if (!empty($parsedCommand)) {
            switch ($parsedCommand[0]) {
                case 'addx':
                    $this->command = $parsedCommand;                    
                    $this->executionCounter = 2;
                    $this->cycle();
                    break;
                case 'noop':
                    $this->cycle();
                    break;
            }
        }
    }

    public function getSignalStrength()
    {
        return $this->signalStrength;
    }
}

class Crt
{
    private $spritePosition = [];

    public function updateSpritePosition(Cpu $cpu)
    {
        $this->spritePosition = array_fill(1,40, '.');
        $x = $cpu->registerX;
        $this->spritePosition[$x] = '#';
        $this->spritePosition[$x+1] = '#';
        $this->spritePosition[$x+2] = '#';
    }

    public function drawPixel(CPU $cpu)
    {
        $cycleSpritePos = $cpu->cycles % 40;
        if ($cycleSpritePos === 0) {
            $cycleSpritePos = 40;
        }
        echo $this->spritePosition[$cycleSpritePos];
        if ($cycleSpritePos === 40) {
            echo PHP_EOL;
        }
    }
}

$cpu = new Cpu();
$crt = new Crt();
$crt->updateSpritePosition($cpu);

/** The sum of these signal strengths is 13140. 20->420 / 60->1140 / 100->1880 / 140->2940 / 180->2880 / 220->3960 */
$input = ["addx 15", "addx -11", "addx 6", "addx -3", "addx 5", "addx -1", "addx -8", "addx 13", "addx 4", "noop", "addx -1", "addx 5", "addx -1", "addx 5", "addx -1", "addx 5", "addx -1", "addx 5", "addx -1", "addx -35", "addx 1", "addx 24", "addx -19", "addx 1", "addx 16", "addx -11", "noop", "noop", "addx 21", "addx -15", "noop", "noop", "addx -3", "addx 9", "addx 1", "addx -3", "addx 8", "addx 1", "addx 5", "noop", "noop", "noop", "noop", "noop", "addx -36", "noop", "addx 1", "addx 7", "noop", "noop", "noop", "addx 2", "addx 6", "noop", "noop", "noop", "noop", "noop", "addx 1", "noop", "noop", "addx 7", "addx 1", "noop", "addx -13", "addx 13", "addx 7", "noop", "addx 1", "addx -33", "noop", "noop", "noop", "addx 2", "noop", "noop", "noop", "addx 8", "noop", "addx -1", "addx 2", "addx 1", "noop", "addx 17", "addx -9", "addx 1", "addx 1", "addx -3", "addx 11", "noop", "noop", "addx 1", "noop", "addx 1", "noop", "noop", "addx -13", "addx -19", "addx 1", "addx 3", "addx 26", "addx -30", "addx 12", "addx -1", "addx 3", "addx 1", "noop", "noop", "noop", "addx -9", "addx 18", "addx 1", "addx 2", "noop", "noop", "addx 9", "noop", "noop", "noop", "addx -1", "addx 2", "addx -37", "addx 1", "addx 3", "noop", "addx 15", "addx -21", "addx 22", "addx -6", "addx 1", "noop", "addx 2", "addx 1", "noop", "addx -10", "noop", "noop", "addx 20", "addx 1", "addx 2", "addx 2", "addx -6", "addx -11", "noop", "noop", "noop"];
$input = loadDay10Data();
$inputCounter = 0;
$sumSignal = 0;
while ($cpu->cycles <=240) {
    if (!$cpu->isBusy()) {
        $cpu->process($input[$inputCounter]);
        $inputCounter++;
        if ($inputCounter == count($input)) {
            $inputCounter = 0;
        }
    } else {
        $cpu->cycle();
    }

    $crt->drawPixel($cpu);
    $crt->updateSpritePosition($cpu);

    if (in_array($cpu->cycles, [20,60,100,140,180,220])) {
        $sumSignal += $cpu->getSignalStrength();
    }
}
var_dump($sumSignal);

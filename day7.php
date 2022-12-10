<?php
require_once "dataloader.php";

class Tdir
{
    public string $name;
    public array $content=[];
    public ?Tdir $parent;

    public function __construct(string $name, $parent)
    {
        $this->name = $name;
        $this->parent = $parent;
    }

    public function addContent($fileOrDir)
    {
        $prefix = $fileOrDir instanceof Tdir ? 'd_' : 'f_';
        $this->content[$prefix.$fileOrDir->name] = $fileOrDir;
    }

    public function cd($name)
    {
        if ($name === '..' && $this->parent !== null) {
            return $this->parent;
        }

        if (array_key_exists('d_'.$name, $this->content)) {
            return $this->content['d_'.$name];
        }
    }

    public function getSize(): int
    {
        $size = 0;
        foreach ($this->content as $fileOrDir) {
            $size += $fileOrDir->getSize();
        }

        return $size;
    }
}

class Tfile
{
    public int $size;
    public string $name;

    public function __construct(string $name, int $size)
    {
        $this->size = $size;
        $this->name = $name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}


function listdir(Tdir &$currentDir, $input, $start)
{
    while ($input[$start][0] !== '$') {
        $content = explode(' ', $input[$start]);
        if ($content[0] === 'dir') {
            $currentDir->addContent(new Tdir($content[1], $currentDir));
        } else {
            $currentDir->addContent(new Tfile($content[1], $content[0]));
        }
        $start++;
        if ($start >= count($input)) {
            break;
        }
    }

    return $start-1;
}


function getDirSumMax100k($dir, $path, $dirSizeList)
{
    $size = 0;
    foreach ($dir->content as $content) {
        $contentSize = $content->getSize();
        $size += $contentSize;
        if ($content instanceof Tdir) {
            $dirSizeList = getDirSumMax100k($content, $path.'->'.$content->name, $dirSizeList);
        }
    }
    $dirSizeList[$path] = $size;

    return $dirSizeList;
}

$input = ["$ cd /", "$ ls", "dir a", "14848514 b.txt", "8504156 c.dat", "dir d", "$ cd a", "$ ls", "dir e", "29116 f", "2557 g", "62596 h.lst", "$ cd e", "$ ls", "584 i", "$ cd ..", "$ cd ..", "$ cd d", "$ ls", "4060174 j", "8033020 d.log", "5626152 d.ext", "7214296 k"];
$input =loadDay7Data();
$currentDir = new Tdir("/", null);
for ($i=1; $i<count($input); $i++) {
    $line = $input[$i];
    if ($line[0] == "$") {
        $command = explode(' ', $line);
        switch ($command[1]) {
            case 'cd':
                $currentDir = $currentDir->cd($command[2]);
                break;
            case 'ls':
                $i = listdir($currentDir, $input, $i+1);
                break;
        }
    }
}

while($currentDir->name !== '/') {
    $currentDir = $currentDir->cd('..');
}
$dirSizeList = getDirSumMax100k($currentDir, $currentDir->name, []);
$arrayMax100k = array_filter($dirSizeList, function ($v, $k) {
    return $v <= 100000;
}, ARRAY_FILTER_USE_BOTH);

asort($dirSizeList);
$freeSize = 70000000 - $currentDir->getSize();
foreach ($dirSizeList as $path => $dirSize) {
    if ($dirSize+$freeSize>=30000000) {
        var_dump($dirSize, $path);
        break;
    }
}

var_dump(array_sum($arrayMax100k));
var_dump($currentDir->getSize());

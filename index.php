<?php

require_once './vendor/autoload.php';

use App\Services\Parser;
use App\Services\Maqe;

$filename = $_SERVER['argv'][1];

$fileObject = new \SplFileObject($filename);
$numberOfCommands = $fileObject->current();
$fileObject->seek(1);

$outputFile = new \SplFileObject('section3.out','w+');

$i = 1;
while (!$fileObject->eof()) {

    $command = $fileObject->current();

    $parser = (new Parser($command));

    $maqe = new Maqe();
    $maqe->runCommand($parser->parseCommand());

    $text = 'Case #' . $i . ': X: ' . $maqe->getX() . ' Y: ' . $maqe->getY() . ' Direction: ' . $maqe->getDirection() . PHP_EOL;

    $outputFile->fwrite($text);

    $fileObject->next();

    $i++;
}
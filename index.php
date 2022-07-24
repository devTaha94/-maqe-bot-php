<?php

require_once './vendor/autoload.php';

use App\Services\CommandParser;
use App\Services\Maqe;
use App\Services\FileWriter;

$filename = $_SERVER['argv'][1];
$parsedCommand = (new CommandParser($filename));

$maqe = new Maqe();
$outputs = $maqe->runCommand($parsedCommand);


/* Not sure */

$result = '';
foreach ($outputs as $key => $value) {
    $result .= 'Case #' . ($key + 1) . ': X: ' . $value['x'] . ' Y: ' . $value['y'] . ' Direction: ' . $value['direction'] . PHP_EOL;
}
/* Not sure */


$fileWriter = new FileWriter();
$fileWriter->write($result,'section3.out');



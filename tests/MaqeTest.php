<?php

use PHPUnit\Framework\TestCase;
use App\Services\CommandParser;
use App\Services\Maqe;
use App\Services\FileWriter;

class MaqeTest extends TestCase
{

    public function testMaqe()
    {
        $parsedCommand = (new CommandParser('section3.in'));
        $this->assertInstanceOf(CommandParser::class,$parsedCommand);

        $maqe = new Maqe();
        $outputs = $maqe->runCommand($parsedCommand);
        $this->assertIsArray($outputs);
        return $outputs;
    }

    /**
     * @depends testMaqe
     */
    public function testMaqeOutputFileResults($outputs)
    {
        $result = '';

        foreach ($outputs as $key => $value) {
            $result .= 'Case #' . ($key + 1) . ': X: ' . $value['x'] . ' Y: ' . $value['y'] . ' Direction: ' . $value['direction'] . PHP_EOL;
        }

        $fileWriter = new FileWriter();
        $fileWriter->write($result,'section3.out');
        $this->assertStringMatchesFormatFile('./section3.out',$result);
    }
}

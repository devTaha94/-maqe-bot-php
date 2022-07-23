<?php

use PHPUnit\Framework\TestCase;

class MaqeTest extends TestCase
{
    public function testMaqe()
    {
        require_once './Services/Maqe.php';
        require_once './Services/WalkingCommand.php';

        $maqe = new Maqe(new WalkingCommand(['','./section3.in']));
        $maqe->run();

        $message = 'Case #1: X: 1 Y: 0 Direction: SOUTH'.PHP_EOL;
        $message.= 'Case #2: X: 55 Y: 99 Direction: EAST'.PHP_EOL;
        $message.= 'Case #3: X: 0 Y: -3 Direction: NORTH'.PHP_EOL;

        $this->assertStringMatchesFormatFile('./section3.out',$message);
    }
}

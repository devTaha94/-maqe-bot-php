<?php

use PHPUnit\Framework\TestCase;

class MaqeTest extends TestCase
{
    public function testMaqe()
    {
        require_once './Maqe.php';
        require_once './WalkingCommand.php';

        $maqe = new Maqe(new WalkingCommand(['RW15RW1']));
        $maqe->run();
        $message = 'X: '.$maqe->getX().' Y: '.$maqe->getY().' Direction: '.$maqe->getDirection();

        $this->assertSame(15,$maqe->getX());
        $this->assertSame(-1,$maqe->getY());
        $this->assertSame('SOUTH',$maqe->getDirection());
        $this->assertSame('X: 15 Y: -1 Direction: SOUTH',$message);
    }
}

<?php

require_once './Interfaces/IWalkingCommand.php';
require_once './Interfaces/IMaqe.php';
require_once 'Messages.php';
require_once 'FileWriter.php';

class Maqe implements IMaqe
{
    private const DIRECTION_NORTH = 0;
    private const DIRECTION_EAST = 1;
    private const DIRECTION_SOUTH = 2;
    private const DIRECTION_WEST = 3;
    private const DIRECTIONS_NAMES = ['NORTH','EAST','SOUTH','WEST'];

    /**
     * @var int
     */
    private int $x = 0;

    /**
     * @var int
     */
    private int $y = 0;

    /**
     * @var int
     */
    private int $direction = self::DIRECTION_NORTH;

    /**
     * @var string
     */
    private string $result = '';

    /**
     * @var array
     */
    private array $walkingCommands;

    /**
     * @param IWalkingCommand $walkingCommand
     */
    public function __construct(IWalkingCommand $walkingCommand)
    {
        $this->walkingCommands = $walkingCommand->getArguments();
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getDirection(): string
    {
        return self::DIRECTIONS_NAMES[$this->direction];
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->walkingCommands as $iterator => $walkingCommands) {
            foreach ($walkingCommands as $key => $command) {
                $rounds = $this->getRoundsCount($walkingCommands,$key);
                if ($command === 'R') {
                    $this->moveClockWise($rounds);
                } elseif ($command === 'L') {
                    $this->moveCounterClockwise($rounds);
                } elseif ($command === 'W') {
                    $this->walkForward($rounds);
                } elseif ($command === 'B') {
                    $this->walkBackwards($rounds);
                }
            }
            $this->result.= $this->prepareResult($iterator);
        }

        (new FileWriter())->write('section3.out',$this->result);

        (new Messages())->getSuccessMessage('Results has been written to section3.out file');
    }

    /**
     * @param $rounds
     * @return void
     */
    private function moveClockWise($rounds): void
    {
        if ($this->direction === self::DIRECTION_WEST) {
            $this->direction = self::DIRECTION_NORTH;
        } else {
            $this->direction += $rounds;
        }
    }

    /**
     * @param $rounds
     * @return void
     */
    private function moveCounterClockwise($rounds): void
    {
        $this->direction -= $rounds;

        if ($this->direction < self::DIRECTION_NORTH) {
            $this->direction = self::DIRECTION_WEST;
        }
    }

    /**
     * @param $steps
     * @return void
     */
    private function walkForward($steps):void
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH;
                $this->y += $steps;
                break;

            case self::DIRECTION_EAST;
                $this->x += $steps;
                break;

            case self::DIRECTION_SOUTH;
                $this->y -= $steps;
                break;

            case self::DIRECTION_WEST;
                $this->x -= $steps;
                break;
        }
    }

    /**
     * @param $steps
     * @return void
     */
    private function walkBackwards($steps):void
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH;
                $this->y -= $steps;
                break;

            case self::DIRECTION_EAST;
                $this->x -= $steps;
                break;

            case self::DIRECTION_SOUTH;
                $this->y += $steps;
                break;

            case self::DIRECTION_WEST;
                $this->x += $steps;
                break;
        }
    }

    /**
     * @param $command
     * @param $key
     * @return int
     */
    private function getRoundsCount($command,$key): int
    {
        $rounds = 1;
        if (isset($command[$key + 1]) && is_numeric($command[$key + 1])) {
            $rounds = $command[$key + 1] ;
        }
        return $rounds;
    }

    private function prepareResult($iterator): string
    {
        $text = 'Case #'.($iterator + 1).': X: '.$this->getX().' Y: '.$this->getY().' Direction: '.$this->getDirection().PHP_EOL;
        $this->x = $this->y = $this->direction = 0;
        return $text;
    }
}

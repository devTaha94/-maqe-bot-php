<?php

namespace App\Services;

use App\Interfaces\BotInterface;
use App\Interfaces\CommandInterface;
use http\Exception\InvalidArgumentException;

class Maqe implements BotInterface
{
    private const DIRECTION_NORTH = 0;
    private const DIRECTION_EAST = 1;
    private const DIRECTION_SOUTH = 2;
    private const DIRECTION_WEST = 3;
    private const DIRECTIONS_NAMES = ['NORTH', 'EAST', 'SOUTH', 'WEST'];

    /**
     * @var int represents position of bot
     */
    private int $x = 0;

    /**
     * @var int represents position of bot
     */
    private int $y = 0;

    /**
     * @var int represents direction of bot
     */
    private int $direction = self::DIRECTION_NORTH;

    /**
     * @return int get current x position
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int  get current y position
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return string get current direction
     */
    public function getDirection(): string
    {
        return self::DIRECTIONS_NAMES[$this->direction];
    }

    /**
     * @return array
     */
    public function runCommand(CommandInterface $command):array
    {
        $results = [];
        $commands = $command->getCommands();

        foreach ($commands as $iteration => $walkingCommands) {
            foreach ($walkingCommands as $key => $command) {
                $rounds = $this->getRoundsCount($walkingCommands, $key);
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

             $results[$iteration]['x'] = $this->getX() ;
             $results[$iteration]['y'] = $this->getY() ;
             $results[$iteration]['direction'] = $this->getDirection() ;

             $this->x = $this->y = $this->direction = 0;
        }
        return $results;
    }

    /**
     * @param $rounds number of iteration around current direction
     * @return void
     */
    private function moveClockWise($rounds): void
    {
        if ($rounds > 4) {
            (new Messages())->getErrorMessage('Direction rounds cannot be grater than 4');
        }

        $this->direction += $rounds;
        $this->direction %= 4;

        if ($this->direction === self::DIRECTION_WEST) {
            $this->direction = self::DIRECTION_NORTH;
        }
    }

    /**
     * @param $rounds number of iteration around current direction
     * @return void
     */
    private function moveCounterClockwise($rounds): void
    {
        if ($rounds > 4) {
            (new Messages())->getErrorMessage('Direction rounds cannot be grater than 4');
        }

        $this->direction -= $rounds;

        if ($this->direction < self::DIRECTION_NORTH) {
            $this->direction = self::DIRECTION_WEST;
        }
    }

    /**
     * @param $steps
     * @return void
     */
    private function walkForward($steps): void
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
    private function walkBackwards($steps): void
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
     * @param $command array of current executed command
     * @param int $key represents current index
     * @return int
     */
    private function getRoundsCount(array $command,int $key): int
    {
        $rounds = 1;
        if (isset($command[$key + 1]) && is_numeric($command[$key + 1])) {
            $rounds = $command[$key + 1];
        }
        return $rounds;
    }
}

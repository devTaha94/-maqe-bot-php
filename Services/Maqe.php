<?php

require_once './Interfaces/IWalkingCommand.php';
require_once 'WalkingCommand.php';
require_once 'Messages.php';

class Maqe
{
    const DIRECTION_NORTH = 0;
    const DIRECTION_EAST = 1;
    const DIRECTION_SOUTH = 2;
    const DIRECTION_WEST = 3;
    const DIRECTIONS_NAMES = ['NORTH','EAST','SOUTH','WEST'];

    /**
     * @var int
     */
    private int $x = 0;
    /**
     * @var int
     */
    private int $y = 0;
    /**
     * @var array
     */
    private array $walkingCommands;
    /**
     * @var int
     */
    private int $direction = self::DIRECTION_NORTH;

    /**
     * @param IWalkingCommand $walkingCommand
     */
    public function __construct(IWalkingCommand $walkingCommand)
    {
        $this->walkingCommands = $walkingCommand->getArguments();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->walkingCommands as $key => $walkingCommand) {
               $rounds = $this->getRoundsCount($key);
               if ($walkingCommand === 'R') {
                   $this->moveClockWise($rounds);
               } elseif ($walkingCommand === 'L') {
                   $this->moveCounterClockwise($rounds);
               } elseif ($walkingCommand === 'W') {
                   $this->walkForward($rounds);
               } elseif ($walkingCommand === 'B') {
                   $this->walkBackwards($rounds);
               }
        }
        $message = 'X: '.$this->x.' Y: '.$this->y.' Direction: '.self::DIRECTIONS_NAMES[$this->direction];
        (new Messages())->getSuccessMessage($message);
    }

    /**
     * @param $key
     * @return int
     */
    private function getRoundsCount($key): int
    {
        $rounds = 1;
        if (isset($this->walkingCommands[$key + 1]) && is_numeric($this->walkingCommands[$key + 1])) {
            $rounds = $this->walkingCommands[$key + 1] ;
        }
        return $rounds;
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
}

unset($_SERVER['argv'][0]);
$maqe = new Maqe(new WalkingCommand($_SERVER['argv']));
$maqe->run();

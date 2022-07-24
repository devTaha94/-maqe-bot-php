<?php

namespace App\Interfaces;

interface BotInterface
{
    /**
     * @return int get current x position
     */
    public function getX(): int;

    /**
     * @return int  get current y position
     */
    public function getY(): int;

    /**
     * @return string get current direction
     */
    public function getDirection(): string;

    /**
     * contains array of outputs
     * @param CommandInterface $command
     * @return array
     */
    public function runCommand(CommandInterface $command): array;
}

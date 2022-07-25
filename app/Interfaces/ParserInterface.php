<?php

namespace App\Interfaces;

interface ParserInterface
{
    /**
     * @param string $command  takes a command to be parsed
     */
    public function __construct(string $command);

    /**
     * @return ParserInterface of parsed commands
     */
    public function parseCommand(): ParserInterface;
}

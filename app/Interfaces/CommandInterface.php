<?php

namespace App\Interfaces;

interface CommandInterface
{
    /**
     * @param string $filename  takes a file name as argument
     */
    public function __construct(string $filename);

    /**
     * @return array of parsed commands
     */
    public function getCommands(): array;
}

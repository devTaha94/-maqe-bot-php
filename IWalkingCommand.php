<?php

require_once 'WalkingCommand.php';

interface IWalkingCommand
{
    /**
     * @return array
     */
    public function getArguments(): array;
}
<?php

namespace App\Services;

use App\Interfaces\ParserInterface;

class Parser implements ParserInterface
{
    /**
     * @var array the result array of commands to be executed
     */
    public array $parsedCommand;

    /**
     * @var string command to be parsed
     */
    private string $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * command ready to be executed
     * @return $this
     */
    public function parseCommand():ParserInterface
    {
        $this ->validateWalkingCommand()
              ->getWalkingCommand();

        return $this;
    }

    /**
     * prepare validation
     * @return $this
     */
    private function validateWalkingCommand()
    {
        $this->command = str_replace(" ", "", strtoupper($this->command));
        $this->command = preg_replace('/\s+/', ' ', trim(  $this->command));

        if (!preg_match("/^[RLWB\d]+$/",  $this->command )) {
            $errorMsg = 'The walking command can be represented with a string consisting of three alphabets R, L and W';
            (new Messages())->getErrorMessage($errorMsg);
        }
        return $this;
    }

    /**
     * separate each alphabet into an array index
     * if alphabets  equals W then next index must be an number
     * @return void
     */
    private function getWalkingCommand(): void
    {
        $commandArr = str_split( $this->command, 1);

        foreach ($commandArr as $key => $argument) {
            if (
                isset($commandArr[$key - 1]) &&
                in_array($commandArr[$key - 1], ['R', 'L', 'B', 'W'])
            ) {
                if (!is_numeric($argument)) {
                    $this->parsedCommand[] = $argument;
                }

                if ($this->createStepsArray($commandArr, $key) !== '') {
                    $this->parsedCommand[] = $this->createStepsArray($commandArr, $key);
                }
            } else {
                is_numeric($argument) ?: $this->parsedCommand[] = $argument;
            }
        }
    }

    /**
     *
     * @param  array $arguments is a part of commands array
     * @param int $key represents the current index
     * @return string represents number of steps foreach action
     */
    private function createStepsArray(array $arguments, int $key): string
    {
        $arrayKey = '';
        $tempArr = array_slice($arguments, $key);
        foreach ($tempArr as $temp) {
            if (is_numeric($temp)) {
                $arrayKey .= $temp;
            } else {
                break;
            }
        }
        return $arrayKey;
    }
}

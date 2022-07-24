<?php

namespace App\Services;

use App\Interfaces\CommandInterface;
use App\Services\Messages;

class CommandParser implements CommandInterface
{
    /**
     * @var int represents number of commands to excute
     */
    private int $iteration;

    /**
     * @var array array of commands
     */
    private array $commandsArr;

    /**
     * @var array the result array of commands to be executed
     */
    private array $commands;

    /**
     * @var string will read commands from this file
     */
    private string $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * commands ready to be excuted
     * @return array
     */
    public function getCommands(): array
    {
        $this->readWalkingCommandsFromFile()
              ->validateWalkingCommand()
              ->getWalkingCommand();

        return $this->commands;
    }

    /**
     * @return $this|void
     */
    private function readWalkingCommandsFromFile()
    {
        try {
            $handle = fopen($this->filename, "r");
            if ($handle) {
                $i = 0;
                while (($line = fgets($handle)) !== false) {
                    if ($i === 0) {
                        if (!is_numeric($line)) {
                            (new Messages())->getErrorMessage('First line must be valid integer');
                        }
                        $this->iteration = $line;
                    } else {
                        $this->commandsArr[] = trim(preg_replace('/\s\s+/', ' ', $line));
                    }
                    $i++;
                }
                fclose($handle);
                return $this;
            }
        } catch (\Exception $exception) {
            (new Messages())->getErrorMessage($exception->getMessage());
        }
    }

    /**
     * prepare validation
     * @return $this|void
     */
    private function validateWalkingCommand()
    {
        try {
            if ($this->iteration != count($this->commandsArr)) {
                (new Messages())->getErrorMessage('Number of walking commands must be equal to ' . $this->iteration);
            }
            $commands = [];
            foreach ($this->commandsArr as $command) {
                $arguments = strtoupper($command);
                $arguments = str_replace(" ", "", $arguments);
                if (preg_match("/^[RLWB\d]+$/", $arguments)) {
                    $arr = str_split($arguments, 1);
                    $commands[] = $arr;
                } else {
                    $errorMsg = 'The walking command can be represented with a string consisting of three alphabets R, L and W';
                    (new Messages())->getErrorMessage($errorMsg);
                }
                $this->commandsArr = $commands;
            }
            return $this;
        } catch (\InvalidArgumentException $exception) {
            (new Messages())->getErrorMessage($exception->getMessage());
        }
    }

    /**
     * separate each alphabet into an array index
     * if alphabets  equals W then next index must be an number
     * @return void
     */
    private function getWalkingCommand(): void
    {
        $tempArr = [];
        foreach ($this->commandsArr as $arguments) {
            foreach ($arguments as $key => $argument) {
                if (
                    isset($arguments[$key - 1]) &&
                    in_array($arguments[$key - 1], ['R', 'L', 'B', 'W'])
                ) {
                    if (!is_numeric($argument)) {
                        $tempArr[] = $argument;
                    }

                    if ($this->createStepsArray($arguments, $key) !== '') {
                        $tempArr[] = $this->createStepsArray($arguments, $key);
                    }
                } else {
                    is_numeric($argument) ?: $tempArr[] = $argument;
                }
            }
            $this->commands[] = $tempArr;
            $tempArr = [];
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

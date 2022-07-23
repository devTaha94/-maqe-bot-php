<?php

require_once './Interfaces/IWalkingCommand.php';
require_once 'Messages.php';

class WalkingCommand implements IWalkingCommand
{
    private int $iteration;
    private array $commandsArr;
    private array $arguments;

    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * chain required functions to prepare walking command
     * @return array
     */
    public function getArguments(): array
    {
        return $this->readWalkingCommandsFromFile()
                    ->validateWalkingCommand()
                    ->getWalkingCommand();
    }

    /**
     * prepare validation
     * @return WalkingCommand
     */
    private function validateWalkingCommand():WalkingCommand
    {
        try {
            if ($this->iteration != count($this->commandsArr)) {
                (new Messages())->getErrorMessage('Number of walking commands must be equal to '.$this->iteration);
                exit();
            }
            $commands = [];
            foreach ($this->commandsArr as $command) {
                $arguments = strtoupper($command);
                $arguments = str_replace(" ", "", $arguments);
                if (preg_match("/^[RLWB\d]+$/", $arguments)) {
                    $arr = str_split($arguments, 1);
                    $commands[] = $arr;
                } else {
                    $errorMsg = 'The walking command can be represented with a string consisting of three alphabets R, L 
                    and W and a positive integer N to indicate the distance of how many positions it has to walk ';
                    (new Messages())->getErrorMessage($errorMsg);
                    exit();
                }
                $this->commandsArr = $commands;
            }
            return $this;
        } catch (InvalidArgumentException $exception) {
                (new Messages())->getErrorMessage($exception->getMessage());
        }
    }

    private function readWalkingCommandsFromFile()
    {
        try {
            $handle = fopen($this->arguments[1], "r");
            if ($handle) {
                $i = 0;
                while (($line = fgets($handle)) !== false) {
                    if ($i === 0) {
                        if (!is_numeric($line)) {
                            (new Messages())->getErrorMessage('First line must be valid integer');
                            exit();
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
        } catch (Exception $exception) {
            (new Messages())->getErrorMessage($exception->getMessage());
        }
    }

    /**
     * separate each alphabet into an array index
     * if alphabets  equals W then next index must be an number
     * @return array
     */
    private function getWalkingCommand(): array
    {
        $preparedArr = [];
        $tempArr = [];
         foreach ($this->commandsArr  as $arguments) {
             foreach ($arguments as $key => $argument) {
                 if (
                     isset($arguments[$key - 1]) &&
                     in_array($arguments[$key - 1],['R','L','B','W'])
                 ) {
                     if (!is_numeric($argument)) {
                         $tempArr[] = $argument;
                     }

                     if ($this->createStepsArray($arguments,$key) !== '') {
                         $tempArr[] = $this->createStepsArray($arguments,$key);
                     }
                 } else {
                     is_numeric($argument) ?: $tempArr[] = $argument;
                 }
             }
             $preparedArr[] = $tempArr;
             $tempArr = [];
        }
        return  $preparedArr;
    }

    /**
     * @param $argument
     * @param $key
     * @return string
     */
    private function createStepsArray($argument,$key): string
    {
        $arrayKey = '';
        $tempArr = array_slice($argument,$key);
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

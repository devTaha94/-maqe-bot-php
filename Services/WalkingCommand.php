<?php


require_once './Interfaces/IWalkingCommand.php';
require_once 'Messages.php';

class WalkingCommand implements IWalkingCommand
{
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
        return $this->validateWalkingCommand()
                    ->getWalkingCommand();
    }

    /**
     * prepare validation
     * @return mixed
     */
    private function validateWalkingCommand(): mixed
    {
        try {
            $arguments = array_values($this->arguments)[0];
            $arguments = strtoupper($arguments);
            $arguments = str_replace(" ", "", $arguments);

            if (preg_match("/^[RLWB\d]+$/", $arguments)) {
                $this->arguments = str_split($arguments, 1);
                return $this;
            } else {
                $errorMsg = 'The walking command can be represented with a string consisting of three alphabets R, L 
                and W and a positive integer N to indicate the distance of how many positions it has to walk ';
                 (new Messages())->getErrorMessage($errorMsg);
            }
        } catch (InvalidArgumentException $exception) {
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
        foreach ($this->arguments  as $key => $argument) {
            if (
                isset($this->arguments[$key - 1]) &&
                in_array($this->arguments[$key - 1],['R','L','B','W'])
            ) {
                if (!is_numeric($argument)) {
                    $preparedArr[] = $argument;
                }

                if ($this->createStepsArray($key) !== '') {
                    $preparedArr[] = $this->createStepsArray($key);
                }
            } else {
                is_numeric($argument) ?: $preparedArr[] = $argument;
            }
        }
        return  $preparedArr;
    }

    /**
     * @param $key
     * @return string
     */
    private function createStepsArray($key): string
    {
        $arrayKey = '';
        $tempArr = array_slice($this->arguments,$key);
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

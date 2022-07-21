<?php


require_once 'IWalkingCommand.php';
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
            //reset argv array index
            $arguments = array_values($this->arguments)[0];

            //remove white spaces if found
            $arguments = str_replace(" ", "", $arguments);

            if (preg_match("/^[RLW\d]+$/", $arguments)) {
                //convert walking code from string to an array
                $this->arguments = str_split($arguments, 1);
                return $this;
            } else {
                $errorMsg = 'The walking command can be represented with a string consisting of three alphabets R, L 
                and W and a positive integer N to indicate the distance of how many positions it has to walk ';
                 (new Messages())->setErrorMessage($errorMsg);
            }
        } catch (InvalidArgumentException $exception) {
                (new Messages())->setErrorMessage($exception->getMessage());
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
            // check if previous argument equals W
            if (isset($this->arguments [$key - 1]) && $this->arguments[$key - 1] === 'W') {
                $arrayKey = '';
                $tempArr = array_slice($this->arguments,$key);
                /*
                    $arr = array_slice($this->arguments,0,$key);
                    $pattern = implode('',$arr);
                    preg_match('/'.$pattern.'\s*(\d+)/', 'RW15', $matches);
                */
                foreach ($tempArr as $temp) {
                    if (is_numeric($temp)) {
                        $arrayKey .= $temp;
                    } else {
                        break;
                    }
                }

                $preparedArr[] = $arrayKey;
            } elseif ($argument === 'W' &&  $key == count($this->arguments)-1 ) {
                unset($this->arguments[count($this->arguments)-1]);
            } else {
                is_numeric($argument) ?: $preparedArr[] = $argument;
            }
        }
        return  $preparedArr;
    }
}

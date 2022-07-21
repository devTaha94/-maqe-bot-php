<?php

use JetBrains\PhpStorm\NoReturn;

require_once './Interfaces/IMessages.php';

class Messages implements IMessages
{
    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function getErrorMessage($message): void
    {
        echo "\033[31m $message \033[0m\n";
    }

    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function getSuccessMessage($message):void
    {
        echo "\033[32m$message \033[0m\n";
    }
}

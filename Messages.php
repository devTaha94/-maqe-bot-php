<?php

use JetBrains\PhpStorm\NoReturn;

class Messages
{
    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function setErrorMessage($message): void
    {
        echo "\033[31m $message \033[0m\n";
    }

    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function setSuccessMessage($message):void
    {
        echo "\033[32m$message \033[0m\n";
    }
}
<?php

use JetBrains\PhpStorm\NoReturn;

interface IMessages
{
    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function getErrorMessage($message): void;

    /**
     * @param $message
     * @return void
     */
    #[NoReturn] public function getSuccessMessage($message):void;
}

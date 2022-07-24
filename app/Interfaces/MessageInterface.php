<?php

namespace App\Interfaces;

interface MessageInterface
{
    /**
     * print colored error messages
     * @param string $message
     * @return void
     */
     public function getErrorMessage(string $message): void;

    /**
     * print colored success messages
     * @param string $message
     * @return void
     */
    public function getSuccessMessage(string $message): void;
}

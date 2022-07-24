<?php

namespace App\Services;

use App\Interfaces\MessageInterface;

class Messages implements MessageInterface
{
    /**
     * print colored error messages
     * @param string $message descriptive error message
     * @return void
     */
    public function getErrorMessage(string $message): void
    {
        echo "\033[31m $message \033[0m\n";
        exit();
    }

    /**
     * print colored success messages
     * @param string $message descriptive success message
     * @return void
     */
     public function getSuccessMessage(string $message): void
    {
        echo "\033[32m$message \033[0m\n";
    }
}

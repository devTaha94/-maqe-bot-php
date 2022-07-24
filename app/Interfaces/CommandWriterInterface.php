<?php

namespace App\Interfaces;

interface CommandWriterInterface
{
    /**
     * implement it to print results
     * @param string $results contains outputs
     * @param string|null $path optionally write to specific path
     * @return void
     */
    public function write(string $results, string|null $path): void;
}

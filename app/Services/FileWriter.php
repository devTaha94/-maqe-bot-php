<?php

namespace App\Services;

use App\Interfaces\CommandWriterInterface;

class FileWriter implements CommandWriterInterface
{
    /**
     * @param string|null $path to write results in
     * @param string $results contains  output
     * @return void
     */
    public function write(string $results,string|null $path): void
    {
        $file = new \SplFileObject($path,'w+');
        $file->fwrite($results);
        $file = null;
    }
}

<?php

require_once './Interfaces/IFileWriter.php';

class FileWriter implements IFileWriter
{
    /**
     * @param $path
     * @param $text
     * @return void
     */
    public function write($path, $text): void
    {
        $fp = fopen($path, 'w');
        fwrite($fp, $text);
        fclose($fp);
    }
}

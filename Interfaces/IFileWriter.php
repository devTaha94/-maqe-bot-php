<?php

interface IFileWriter
{
    /**
     * @param $path
     * @param $text
     * @return void
     */
    public function write($path, $text):void;
}

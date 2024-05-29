<?php

namespace App\Service\Filesystem;

class FileWritter
{
    private $file;

    public function __construct()
    {
    }

    public function open(string $filename): void
    {
        $this->file = fopen($filename, 'w');
    }

    public function write(string $line): void
    {
        fwrite($this->file, $line);
    }

    public function close(): void
    {
        fclose($this->file);
    }
}

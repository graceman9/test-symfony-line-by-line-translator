<?php

namespace App\Service\Filesystem;

use Generator;

class BigFileReader
{
    private $file;

    public function __construct()
    {
    }

    public function open(string $filename): void
    {
        $this->file = fopen($filename, 'r');
    }

    public function read(): Generator
    {
        while (!feof($this->file)) {
            yield fgets($this->file);
        }
    }

    public function close(): void
    {
        fclose($this->file);
    }
}

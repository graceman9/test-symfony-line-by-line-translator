<?php

namespace App\Contracts;

interface TranslatorInterface
{
    public function translate(string $line): string;
}

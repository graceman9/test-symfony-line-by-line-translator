<?php

namespace App\Service\Translator;

use App\Contracts\TranslatorInterface;

class SimpleTranslator implements TranslatorInterface
{
    public function translate(string $line): string
    {
        return 'Translation by SimpleTranslator: ' . $line;
    }
}

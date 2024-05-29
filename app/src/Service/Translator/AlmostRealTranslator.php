<?php

namespace App\Service\Translator;

use App\Contracts\TranslatorInterface;

class AlmostRealTranslator implements TranslatorInterface
{
    public function translate(string $line): string
    {
        // http request to translation service
        sleep(3);

        return 'Translation by AlmostRealTranslator: ' . $line;
    }
}

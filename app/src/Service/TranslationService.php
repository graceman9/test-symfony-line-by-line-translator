<?php

namespace App\Service;

use App\Exception\InvalidTranslatorException;
use App\Service\Filesystem\BigFileReader;
use App\Service\Filesystem\FileWritter;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class TranslationService
{
    public function __construct(
        private readonly BigFileReader $bigFileReader,
        private readonly FileWritter $fileWritter,
        private readonly iterable $translators,
        #[Autowire('%kernel.project_dir%/var/data-to-translate/')]
        private readonly string $dataDir,
    ) {
    }

    public function translate(
        string $srcFilename,
        string $destFilepath,
        string $translatorFQCN,
    ): void {
        // strategy
        $translator = $this->translators[$translatorFQCN] ?? null;
        if (is_null($translator)) {
            throw new InvalidTranslatorException();
        }

        // open
        $srcFilepath = $this->dataDir . $srcFilename;

        // DEBUG: memory usage
        // $a = file_get_contents($srcFilepath);

        $this->bigFileReader->open($srcFilepath);

        $destFullpath = $this->dataDir . $destFilepath;
        $destDir = pathinfo($destFullpath, PATHINFO_DIRNAME);
        if (!file_exists($destDir)) {
            mkdir($destDir, 0777, true);
        }
        $this->fileWritter->open($destFullpath);

        foreach ($this->bigFileReader->read() as $line) {
            $translatedLine = $translator->translate($line);
            $this->fileWritter->write($translatedLine);
        }

        // close
        $this->bigFileReader->close();
        $this->fileWritter->close();

        // DEBUG: memory usage
        // $u = memory_get_usage(true);
        // dump($u / 1024 / 1024);
    }
}

<?php

namespace App\Command;

use App\Exception\InvalidTranslatorException;
use App\Service\TranslationService;
use App\Service\Translator\SimpleTranslator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:translate-file',
    description: 'Translate file line by line',
)]
class TranslateFileCommand extends Command
{
    const ARG_SRC = 'src';
    const ARG_DEST = 'dest';
    const OPTION_TRANSLATOR = 'translator';

    public function __construct(
        private readonly TranslationService $translationService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::ARG_SRC, InputArgument::REQUIRED, 'Source filename ')
            ->addArgument(self::ARG_DEST, InputArgument::OPTIONAL, 'Destination filename')
            ->addOption(self::OPTION_TRANSLATOR, '-t', InputOption::VALUE_REQUIRED, 'Translation service class name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // src
        $src = $input->getArgument(self::ARG_SRC);

        // dest
        $defaultDest = 'translation/' . pathinfo($src, PATHINFO_BASENAME);
        $dest = !empty($input->getArgument(self::ARG_DEST))
            ? $input->getArgument(self::ARG_DEST)
            : $defaultDest;

        // translator
        $translatorFQCN = !empty($input->getOption(self::OPTION_TRANSLATOR))
            ? 'App\\Service\\Translator\\' . $input->getOption(self::OPTION_TRANSLATOR)
            : SimpleTranslator::class;

        // do translate
        try {
            $this->translationService->translate($src, $dest, $translatorFQCN);
        } catch (InvalidTranslatorException $e) {
            $io->error(sprintf('Invalid translator, translator = %s', $input->getOption(self::OPTION_TRANSLATOR)));
            return Command::FAILURE;
        }

        $io->success(sprintf('Document translated successfully with %s translator, document = %s', $translatorFQCN, $src));

        return Command::SUCCESS;
    }
}

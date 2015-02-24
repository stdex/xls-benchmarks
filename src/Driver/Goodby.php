<?php

namespace CsvBenchmarks\Driver;

use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;

class Goodby implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "goodby/csv";
    }

    /**
     * {@inheritdoc}
     */
    public function runReader($file)
    {
        $nbrows = 0;
        $interpreter = new Interpreter();
        $interpreter->addObserver(function (array $rows) use (&$nbrows) {
            ++$nbrows;
        });
        $lexer = new Lexer(new LexerConfig());
        $lexer->parse($file, $interpreter);

        return $nbrows;
    }

    /**
     * {@inheritdoc}
     */
    public function runWriter($file, $nbrows)
    {
        $exporter = new Exporter(new ExporterConfig());
        $exporter->export($file, generateRawData($nbrows));
        $exporter = null;

        return $nbrows;
    }
}

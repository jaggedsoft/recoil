<?php

declare (strict_types = 1); // @codeCoverageIgnore

use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Peridot\Reporter\CodeCoverage\AbstractCodeCoverageReporter;
use Peridot\Reporter\CodeCoverageReporters;

require __DIR__ . '/vendor/autoload.php';

error_reporting(-1);
ini_set('zend.assertions', '1');
ini_set('assert.exception', '1');

return function (EventEmitterInterface $emitter) {
    (new CodeCoverageReporters($emitter))->register();

    $emitter->on('peridot.start', function (Environment $environment) {
        $environment->getDefinition()->getArgument('path')->setDefault('test/suite');
    });

    $emitter->on('code-coverage.start', function (AbstractCodeCoverageReporter $reporter) {
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src');
        $reporter->addDirectoryToWhitelist(__DIR__ . '/src-internal');
    });
};

<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('bootstrap')
    ->exclude('storage')
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setFinder($finder);

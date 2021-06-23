<?php

$finder = (new PhpCsFixer\Finder())
    ->in(dirname(__DIR__).'/src')
//    ->in(dirname(__DIR__).'/tests')
;

return (new PhpCsFixer\Config())
    ->setUsingCache(false)
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder)
;

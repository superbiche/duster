<?php

use Tightenco\Duster\App\Fixer\ClassNotation\CustomOrderedClassElementsFixer;
use Tightenco\Duster\App\Support\PhpCsFixer;
use PhpCsFixer\Config;

return (new Config())
    ->setFinder(PhpCsFixer::getFinder())
    ->setUsingCache(false)
    ->registerCustomFixers([new CustomOrderedClassElementsFixer()])
    ->setRules([
        'Tighten/custom_ordered_class_elements' => [
            'order' => [
                'method_public',
                'method:__invoke',
            ],
        ],
    ]);

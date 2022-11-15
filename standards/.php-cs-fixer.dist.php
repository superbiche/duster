<?php

use App\Fixer\ClassNotation\CustomControllerOrderFixer;
use App\Fixer\ClassNotation\CustomOrderedClassElementsFixer;
use App\Support\PhpCsFixer;
use PhpCsFixer\Config;

return (new Config())
    ->setFinder(PhpCsFixer::getFinder())
    ->setUsingCache(false)
    ->registerCustomFixers([
        new CustomOrderedClassElementsFixer(),
        new CustomControllerOrderFixer(),
    ])
    ->setRules([
        'Tighten/custom_controller_order' => true,
        'Tighten/custom_ordered_class_elements' => [
            'order' => [
                'use_trait',
                'property_public_static',
                'property_protected_static',
                'property_private_static',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'method:__invoke',
                'method_public_static',
                'method_protected_static',
                'method_private_static',
                'method_public',
                'method_protected',
                'method_private',
                'magic',
            ],
        ],
    ]);

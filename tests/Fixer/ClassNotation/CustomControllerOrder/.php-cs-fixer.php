<?php

use Tightenco\Duster\App\Fixer\ClassNotation\CustomControllerOrderFixer;
use PhpCsFixer\Config;

return (new Config())
    ->setUsingCache(false)
    ->registerCustomFixers([new CustomControllerOrderFixer()])
    ->setRules(['Tighten/custom_controller_order' => true]);

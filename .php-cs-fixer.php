<?php

return new PhpCsFixer\Config()
    ->setCacheFile(__DIR__ . '/var/.php_cs.cache')
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__ . '/src',
                __DIR__ . '/tests',
                __DIR__ . '/public',
            ])
            ->append([
                __FILE__,
            ])
    )
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP84Migration' => true,
        '@PHPUnit100Migration:risky' => true,

        'no_unused_imports' => true,
        'ordered_imports' => true,

        'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => true],

        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],

        'strict_comparison' => true,
        'strict_param' => true,

        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],

        'no_superfluous_elseif' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,

        'php_unit_internal_class' => true,
        'php_unit_construct' => true,
        'php_unit_fqcn_annotation' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],

        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'self_static_accessor' => true,

        'static_lambda' => true,

        'global_namespace_import' => true,
    ]);

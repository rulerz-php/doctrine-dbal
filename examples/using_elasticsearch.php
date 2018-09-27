<?php

declare(strict_types=1);

list($rulerz, $client) = require_once __DIR__.'/bootstrap.php';

$client = new Elasticsearch\Client([
    'hosts' => ['localhost:9200'],
]);

// compiler
$compiler = \RulerZ\Compiler\Compiler::create();

// RulerZ engine
$rulerz = new \RulerZ\RulerZ(
    $compiler, [
        new \RulerZ\Target\Elasticsearch\Elasticsearch(),
    ]
);

// 1. Write a rule.
$rule = 'gender = :gender';

// 2. Define the execution context
$context = [
    'index' => 'rulerz_tests',
    'type' => 'player',
];

// 3. Enjoy!
$parameters = [
    'gender' => 'F',
];

$players = $rulerz->filter($client, $rule, $parameters, $context);

var_dump(iterator_to_array($players));

<?php

declare(strict_types=1);

/** @var \RulerZ\RulerZ $rulerz */
/** @var \Doctrine\DBAL\Connection $connection */
list($rulerz, $connection) = require_once __DIR__.'/bootstrap.php';

$queryBuilder = $connection->createQueryBuilder();

$queryBuilder
    ->select('pseudo', 'gender', 'points')
    ->from('players');

// 1. Write a rule.
$rule = 'gender = :gender';

// 2. Define the parameters.
$parameters = [
    'gender' => 'F',
];

// 3. Enjoy!
$players = $rulerz->filter($queryBuilder, $rule, $parameters);

var_dump(iterator_to_array($players));

<?php

declare(strict_types=1);

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

require_once __DIR__.'/../vendor/autoload.php';

$connectionParams = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/rulerz.db', // meh.
];
$connection = DriverManager::getConnection($connectionParams, new Configuration());

// compiler
$compiler = \RulerZ\Compiler\Compiler::create();

// RulerZ engine
$rulerz = new \RulerZ\RulerZ(
    $compiler, [
        new \RulerZ\DoctrineDBAL\Target\DoctrineDBAL(),
    ]
);

return [$rulerz, $connection];

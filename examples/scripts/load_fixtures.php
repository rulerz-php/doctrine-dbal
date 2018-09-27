#!/usr/bin/env php
<?php

/** @var \Doctrine\DBAL\Connection $connection */
list($rulerz, $connection) = require_once __DIR__ . '/../bootstrap.php';

$fixtures = json_decode(file_get_contents(__DIR__.'/../../vendor/kphoen/rulerz/examples/fixtures.json'), true);

$groups = [];

echo sprintf("\e[32mLoading fixtures for %d groups\e[0m".PHP_EOL, count($fixtures['groups']));

foreach ($fixtures['groups'] as $slug => $group) {
    $groups[$slug] = count($groups) + 1;

    $connection->executeQuery('INSERT INTO groups (id, name) VALUES (?, ?)', [
        $groups[$slug],
        $group['name'],
    ]);
}

echo sprintf("\e[32mLoading fixtures for %d players\e[0m".PHP_EOL, count($fixtures['players']));

foreach ($fixtures['players'] as $player) {
    $params = [
        'body' => [
            'pseudo' => $player['pseudo'],
            'fullname' => $player['fullname'],
            'birthday' => $player['birthday'],
            'gender' => $player['gender'],
            'points' => $player['points'],
        ],
        'index' => 'rulerz_tests',
        'type' => 'player',
        'id' => uniqid(),
    ];

    $connection->executeQuery('INSERT INTO players (pseudo, group_id, fullname, gender, birthday, points, address_street, address_postalCode, address_city, address_country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        $player['pseudo'],
        $groups[$player['group']],
        $player['fullname'],
        $player['gender'],
        $player['birthday'],
        $player['points'],
        $player['address']['street'],
        $player['address']['postalCode'],
        $player['address']['city'],
        $player['address']['country'],
    ]);
}

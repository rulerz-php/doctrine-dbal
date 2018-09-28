<?php

declare(strict_types=1);

use Behat\Behat\Context\Context as BehatContext;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use RulerZ\Test\BaseContext;

class Context extends BaseContext implements BehatContext
{
    /** @var \Doctrine\DBAL\Connection */
    private $connection;

    public function initialize()
    {
        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__.'/../../examples/rulerz.db', // meh.
        ];

        $this->connection = DriverManager::getConnection($connectionParams, new Configuration());
    }

    /**
     * {@inheritdoc}
     */
    protected function getCompilationTarget(): \RulerZ\Compiler\CompilationTarget
    {
        return new \RulerZ\DoctrineDBAL\Target\DoctrineDBAL();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDataset()
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('players');
    }
}

<?php

declare(strict_types=1);

namespace RulerZ\DoctrineDBAL\Target;

use Doctrine\DBAL\Query\QueryBuilder;
use RulerZ\DoctrineDBAL\Executor\FilterTrait;
use RulerZ\Executor\Polyfill\FilterBasedSatisfaction;
use RulerZ\Target\AbstractSqlTarget;

class DoctrineDBAL extends AbstractSqlTarget
{
    /**
     * {@inheritdoc}
     */
    public function supports($target, string $mode): bool
    {
        return $target instanceof QueryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExecutorTraits()
    {
        return [
            FilterTrait::class,
            FilterBasedSatisfaction::class,
        ];
    }
}

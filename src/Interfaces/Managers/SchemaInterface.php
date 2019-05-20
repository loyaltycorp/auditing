<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Managers;

use LoyaltyCorp\Auditing\Interfaces\EntityInterface;

interface SchemaInterface
{
    /**
     * Create table.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\EntityInterface $entity
     *
     * @return bool
     */
    public function create(EntityInterface $entity): bool;

    /**
     * Drop table.
     *
     * @param string $tableName Table name to be dropped
     *
     * @return bool
     */
    public function drop(string $tableName): bool;
}

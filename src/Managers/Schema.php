<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Interfaces\EntityInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;
use LoyaltyCorp\Auditing\Manager;

final class Schema extends Manager implements SchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(EntityInterface $entity): bool
    {
        $this->getDbClient()->createTable($entity->toArray());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function drop(string $tableName): bool
    {
        $this->getDbClient()->deleteTable([
            self::TABLE_NAME_KEY => $tableName
        ]);

        return true;
    }
}

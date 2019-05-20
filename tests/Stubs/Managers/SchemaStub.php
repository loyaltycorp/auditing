<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Managers;

use LoyaltyCorp\Auditing\Interfaces\EntityInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;

/**
 * @coversNothing
 */
class SchemaStub implements SchemaInterface
{
    /**
     * @inheritdoc
     */
    public function create(EntityInterface $entity): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function drop(string $tableName): bool
    {
        return true;
    }
}

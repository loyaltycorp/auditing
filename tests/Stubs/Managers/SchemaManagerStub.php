<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Managers;

use LoyaltyCorp\Auditing\Interfaces\DocumentInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;

/**
 * @coversNothing
 */
class SchemaManagerStub implements SchemaManagerInterface
{
    /**
     * @inheritdoc
     */
    public function create(DocumentInterface $entity): bool
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

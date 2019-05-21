<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Interfaces\DocumentInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Manager;

final class SchemaManager extends Manager implements SchemaManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(DocumentInterface $entity): bool
    {
        $this->getDbClient()->createTable($entity->toArray());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function drop(string $documentClass): bool
    {
        $document = $this->getDocumentObject($documentClass);

        $this->getDbClient()->deleteTable([
            self::TABLE_NAME_KEY => $document->getTableName()
        ]);

        return true;
    }
}

<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Interfaces\DocumentInterface;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\ManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;

final class SchemaManager implements DynamoDbAwareInterface, SchemaManagerInterface
{
    /**
     * Manager instance.
     *
     * @var \LoyaltyCorp\Auditing\Interfaces\ManagerInterface
     */
    private $manager;

    /**
     * Construct schema manager
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(DocumentInterface $entity): bool
    {
        $tableArguments = $entity->toArray();
        $tableArguments['TableName'] = $this->manager->getTableName($tableArguments['TableName']);

        $this->manager->getDbClient()->createTable($tableArguments);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function drop(string $documentClass): bool
    {
        $document = $this->manager->getDocumentObject($documentClass);
        $tableName = $this->manager->getTableName($document->getTableName());

        $this->manager->getDbClient()->deleteTable([
            self::TABLE_NAME_KEY => $tableName
        ]);

        return true;
    }
}

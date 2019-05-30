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
        $this->manager->getDbClient()->createTable($entity->toArray());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function drop(string $documentClass): bool
    {
        $document = $this->manager->getDocumentObject($documentClass);

        $this->manager->getDbClient()->deleteTable([
            self::TABLE_NAME_KEY => $document->getTableName()
        ]);

        return true;
    }
}

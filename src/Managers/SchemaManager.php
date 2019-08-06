<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use Aws\DynamoDb\Exception\DynamoDbException;
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

        try {
            $this->manager->getDbClient()->deleteTable([
                self::TABLE_NAME_KEY => $tableName
            ]);
        } catch (DynamoDbException $exception) {
            if ($this->canHandleException($exception) === false) {
                throw $exception;
            }
        }

        return true;
    }

    /**
     * Assert if an exception can be handled and operation can be continued.
     *
     * @param \Aws\DynamoDb\Exception\DynamoDbException $exception
     *
     * @return bool
     */
    private function canHandleException(DynamoDbException $exception): bool
    {
        $command = $exception->getCommand()->getName();
        $errorCode = $exception->getAwsErrorCode();
        $response = $exception->getResponse();
        $statusCode = $response === null ? 0 : $response->getStatusCode();

        if ($command === 'DeleteTable' &&
            $errorCode === 'ResourceNotFoundException' &&
            $statusCode === 400) {
            // known exception thrown when trying to delete non-existent table
            return true;
        }

        return false;
    }
}

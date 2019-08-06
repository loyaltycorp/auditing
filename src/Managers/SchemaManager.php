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

        try {
            $this->manager->getDbClient()->createTable($tableArguments);
        } catch (DynamoDbException $exception) {
            if ($this->canHandleCreateException($exception) === false) {
                throw $exception;
            }
        }

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
            if ($this->canHandleDropException($exception) === false) {
                throw $exception;
            }
        }

        return true;
    }

    /**
     * Assert if an exception while creating can be handled and
     * operation can be continued.
     *
     * @param \Aws\DynamoDb\Exception\DynamoDbException $exception
     *
     * @return bool
     */
    private function canHandleCreateException(DynamoDbException $exception): bool
    {
        /**
         * AWS throws ResourceInUseException
         * when you try to create an existing table.
         *
         * @see https://docs.aws.amazon.com/amazondynamodb/latest/APIReference/API_CreateTable.html#API_CreateTable_Errors
         */
        return $this->canHandleException(
            'CreateTable',
            'ResourceInUseException',
            $exception,
            400
        );
    }

    /**
     * Assert if an exception while dropping can be handled and
     * operation can be continued.
     *
     * @param \Aws\DynamoDb\Exception\DynamoDbException $exception
     *
     * @return bool
     */
    private function canHandleDropException(DynamoDbException $exception): bool
    {
        /**
         * AWS throws ResourceNotFoundException
         * when you try to delete a non existent table.
         *
         * @see https://docs.aws.amazon.com/amazondynamodb/latest/APIReference/API_DeleteTable.html#API_DeleteTable_Errors
         */
        return $this->canHandleException(
            'DeleteTable',
            'ResourceNotFoundException',
            $exception,
            400
        );
    }

    /**
     * Assert if an exception can be handled based on criteria provided.
     *
     * @param string $command AWS dynamoDb command.
     * @param string $errorCode AWS error code.
     * @param \Aws\DynamoDb\Exception\DynamoDbException $exception
     * @param int $statusCode AWS server response code.
     *
     * @return bool
     */
    private function canHandleException(
        string $command,
        string $errorCode,
        DynamoDbException $exception,
        int $statusCode
    ): bool {
        $awsCommand = $exception->getCommand()->getName();
        $awsErrorCode = $exception->getAwsErrorCode();
        $response = $exception->getResponse();
        $awsStatusCode = $response === null ? 0 : $response->getStatusCode();

        return
            $awsCommand === $command &&
            $awsErrorCode === $errorCode &&
            $awsStatusCode === $statusCode;
    }
}

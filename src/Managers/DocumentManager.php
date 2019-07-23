<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Result;
use LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException;
use LoyaltyCorp\Auditing\Exceptions\DocumentQueryFailedException;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\ManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\ResponseInterface;
use LoyaltyCorp\Auditing\Response;

final class DocumentManager implements DocumentManagerInterface, DynamoDbAwareInterface
{
    /**
     * Manager instance.
     *
     * @var \LoyaltyCorp\Auditing\Interfaces\ManagerInterface
     */
    private $manager;

    /**
     * Construct document manager.
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
    public function create(DataObjectInterface $dataObject): ResponseInterface
    {
        $attemptCounter = 0;
        $result = null;

        do {
            $data = \array_merge($dataObject->toArray(), [
                'requestId' => $this->manager->getGenerator()->uuid4()
            ]);

            $item = $this->manager->getMarshaler()->marshalJson(\json_encode($data) ?: '');

            try {
                $attemptCounter++;
                $tableName = $this->manager->getTableName($dataObject->getTableName());
                $result = $this->manager->getDbClient()->putItem([
                    self::TABLE_NAME_KEY => $tableName,
                    self::TABLE_ITEM_KEY => $item,
                    self::CONDITION_EXPRESSION_KEY => 'attribute_not_exists (requestId)'
                ]);
            } catch (DynamoDbException $exception) {
                // put condition check fail (duplicate id), try again.
                if ($exception->getAwsErrorCode() === 'ConditionalCheckFailedException') {
                    \sleep(2); // just take a breath before continuing
                    continue;
                }
                // other exception
                throw new DocumentCreateFailedException(
                    'Unable to save the document.',
                    null,
                    $exception
                );
            }
        } while ($attemptCounter < self::DEFAULT_MAX_ATTEMPTS && $result === null);

        // all attempts were exhausted and still could not find a unique request id for the document.
        if (($result instanceof Result) !== true) {
            throw new DocumentCreateFailedException('Unable to find available request ID for the document.');
        }

        /**
         * @var \Aws\Result $result
         *
         * @see https://youtrack.jetbrains.com/issue/WI-37859 - typehint required until PhpStorm recognises === check
         */
        return new Response($result->toArray()['Items'] ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function list(
        string $documentClass,
        ?string $expression = null,
        ?array $attributeValues = null
    ): array {
        $items = [];
        $document = $this->manager->getDocumentObject($documentClass);
        $tableName = $this->manager->getTableName($document->getTableName());

        try {
            $result = $this->manager->getDbClient()->scan([
                self::TABLE_NAME_KEY => $tableName,
                'FilterExpression' => $expression ?? '',
                'ExpressionAttributeValues' => $this->manager->getMarshaler()->marshalJson(
                    \json_encode($attributeValues ?? []) ?: ''
                )
            ]);

            $marshaledItems = $result->get('Items');

            foreach ($marshaledItems as $item) {
                $items[] = $this->manager->getMarshaler()->unmarshalItem($item);
            }

            return $items;
        } catch (DynamoDbException $exception) {
            throw new DocumentQueryFailedException('Failed to query document.', null, $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $objectId, DataObjectInterface $dataObject): ResponseInterface
    {
        $data = \array_merge($dataObject->toArray(), [
            'requestId' => $objectId
        ]);

        $item = $this->manager->getMarshaler()->marshalJson(\json_encode($data) ?: '');
        $tableName = $this->manager->getTableName($dataObject->getTableName());

        $result = $this->manager->getDbClient()->putItem([
            self::TABLE_NAME_KEY => $tableName,
            self::TABLE_ITEM_KEY => $item,
            self::CONDITION_EXPRESSION_KEY => 'attribute_exists (requestId)'
        ]);

        return new Response($result->toArray()['Items'] ?? []);
    }
}

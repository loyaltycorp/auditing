<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Result;
use LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException;
use LoyaltyCorp\Auditing\Exceptions\DocumentQueryFailedException;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Manager;

final class DocumentManager extends Manager implements DocumentManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(DataObjectInterface $dataObject): Result
    {
        $attemptCounter = 0;
        $result = null;

        do {
            $data = \array_merge($dataObject->toArray(), [
                'requestId' => $this->getGenerator()->uuid4()
            ]);

            $item = $this->getMarshaler()->marshalJson(\json_encode($data) ?: '');

            try {
                $attemptCounter++;
                $result = $this->getDbClient()->putItem([
                    self::TABLE_NAME_KEY => $dataObject->getTableName(),
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

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function list(
        string $documentClass,
        ?string $expression = null,
        ?array $attributeValues = null
    ): Result {
        $document = $this->getDocumentObject($documentClass);

        try {
            return $this->getDbClient()->scan([
                self::TABLE_NAME_KEY => $document->getTableName(),
                'FilterExpression' => $expression ?? '',
                'ExpressionAttributeValues' => $this->getMarshaler()->marshalJson(
                    \json_encode($attributeValues ?? []) ?: ''
                )
            ]);
        } catch (DynamoDbException $exception) {
            throw new DocumentQueryFailedException('Failed to query document.', null, $exception);
        }
    }
}

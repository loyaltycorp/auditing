<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use Aws\CommandInterface;
use Aws\DynamoDb\Exception\DynamoDbException;
use LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException;
use LoyaltyCorp\Auditing\Exceptions\DocumentQueryFailedException;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use Psr\Http\Message\RequestInterface;
use Tests\LoyaltyCorp\Auditing\Stubs\DocumentStub;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\UuidGeneratorStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Managers\DocumentManager
 */
class DocumentManagerTest extends TestCase
{
    /**
     * Test create document item fails with exception.
     *
     * @return void
     */
    public function testCreateFailsWithException(): void
    {
        $this->expectException(DocumentCreateFailedException::class);
        $this->expectExceptionMessage('Unable to save the document.');

        $this->getDocumentManager([
            'message' => 'Creating document failed.'
        ], true)->create(new DtoStub());
    }

    /**
     * Test create document item fails with exception after retries.
     *
     * @return void
     */
    public function testCreateFailsWithExceptionAfterRetries(): void
    {
        $this->expectException(DocumentCreateFailedException::class);
        $this->expectExceptionMessage('Unable to find available request ID for the document.');

        $this->getDocumentManager([
            'message' => 'Creating document failed.',
            'code' => 'ConditionalCheckFailedException'
        ], true, true)->create(new DtoStub());
    }

    /**
     * Test create document item in db successfully.
     *
     * @return void
     */
    public function testCreateSuccessfully(): void
    {
        $result = $this->getDocumentManager([
            'test' => 'ok'
        ])->create(new DtoStub());

        self::assertSame('ok', $result->get('test'));
    }

    /**
     * Test that list document items will return expected number of items.
     *
     * @return void
     */
    public function testListSuccessfully(): void
    {
        $json1 = \json_encode(['attr' => 'value1']) ?: '';
        $json2 = \json_encode(['attr' => 'value2']) ?: '';
        $results = $this->getDocumentManager([
            'Items' => [
                $this->getMarshaler()->marshalJson($json1),
                $this->getMarshaler()->marshalJson($json2)
            ]
        ])->list(DocumentStub::class, 'attr = :val', ['val' => 'value']);

        self::assertCount(2, $results);
    }

    /**
     * Test the list document items will throw DocumentQueryFailedException
     *
     * @return void
     */
    public function testListThrowsException(): void
    {
        $this->expectException(DocumentQueryFailedException::class);
        $this->expectExceptionMessage('Failed to query document.');

        $this->getDocumentManager([
            'message' => 'Failed to retrieve document items.'
        ], true)->list(DocumentStub::class, 'attr = :val', ['val' => 'value']);
    }

    /**
     * Test update document successfully.
     *
     * @return void
     */
    public function testUpdateSuccessfully(): void
    {
        $result = $this->getDocumentManager([
            'test' => 'ok'
        ])->update('request-id', new DtoStub());

        self::assertSame('ok', $result->get('test'));
    }

    /**
     * Get document manager.
     *
     * @param mixed[]|null $data
     * @param bool|null $exception
     * @param bool|null $retries
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable) The request variable is unused intentionally
     */
    private function getDocumentManager(
        ?array $data = null,
        ?bool $exception = null,
        ?bool $retries = null
    ): DocumentManagerInterface {
        $handler = $this->createMockHandler($data, $exception);

        if ($retries === true) {
            for ($i = 1; $i < DynamoDbAwareInterface::DEFAULT_MAX_ATTEMPTS; $i++) {
                $handler->append(function (CommandInterface $cmd, RequestInterface $req) use ($data) {
                    return new DynamoDbException(
                        $data['message'] ?? 'Mock exception.',
                        $cmd,
                        $data ?? []
                    );
                });
            }
        }

        return new DocumentManager(
            $this->getConnection($handler),
            new UuidGeneratorStub()
        );
    }
}

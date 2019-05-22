<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use Aws\CommandInterface;
use Aws\DynamoDb\Exception\DynamoDbException;
use LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException;
use LoyaltyCorp\Auditing\Interfaces\DynamoDbAwareInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Managers\DocumentManager;
use Psr\Http\Message\RequestInterface;
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
     * Test create document item in db successfully.
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
     * Test create document item in db successfully.
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
     * Get document manager.
     *
     * @param mixed[]|null $data
     * @param bool|null $exception
     * @param bool|null $retries
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface
     */
    private function getDocumentManager(?array $data = null, ?bool $exception = null, ?bool $retries = null): DocumentManagerInterface
    {
        $handler = $this->createMockHandler($data, $exception);

        if ($retries === true) {
            for ($i = 1; $i < DynamoDbAwareInterface::DEFAULT_MAX_ATTEMPTS; $i++) {
                $handler->append(function (CommandInterface $cmd, RequestInterface $req) use ($data) {
                    return new DynamoDbException(
                        $data['message'] ?? 'Mock exception.',
                        $cmd,
                        $data
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

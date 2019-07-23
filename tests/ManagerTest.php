<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing;

use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Interfaces\ManagerInterface;
use LoyaltyCorp\Auditing\Manager;
use Tests\LoyaltyCorp\Auditing\Stubs\DocumentStub;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\UuidGeneratorStub;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 */
class ManagerTest extends TestCase
{
    /**
     * Test that get dbclient returns expect dynamodb client.
     *
     * @return void
     */
    public function testGetDbClient(): void
    {
        $dbClient = $this->getManager()->getDbClient();

        self::assertSame('localhost', $dbClient->getEndpoint()->getHost());
        self::assertSame(8000, $dbClient->getEndpoint()->getPort());
        self::assertSame('ap-southeast-2', $dbClient->getRegion());
    }

    /**
     * Test that get document object returns expected document object.
     *
     * @return void
     */
    public function testGetDocumentObject(): void
    {
        $document = $this->getManager()->getDocumentObject(DocumentStub::class);

        self::assertInstanceOf(DocumentStub::class, $document);
    }

    /**
     * Test that get document object throws exception when class name is not a document class.
     *
     * @return void
     */
    public function testGetDocumentObjectThrowsExceptionWhenClassNotADocument(): void
    {
        $documentClass = DtoStub::class;

        $this->expectException(InvalidDocumentClassException::class);
        $this->expectExceptionMessage(\sprintf(
            'Provided document class (%s) is invalid or does not exist.',
            $documentClass
        ));

        $this->getManager()->getDocumentObject($documentClass);
    }

    /**
     * Test that get document object throws exception when class does not exists.
     *
     * @return void
     */
    public function testGetDocumentObjectThrowsExceptionWhenClassNotExists(): void
    {
        $documentClass = 'InvalidClass';

        $this->expectException(InvalidDocumentClassException::class);
        $this->expectExceptionMessage(\sprintf(
            'Provided document class (%s) is invalid or does not exist.',
            $documentClass
        ));

        $this->getManager()->getDocumentObject($documentClass);
    }

    /**
     * Test get generator returns uuid generator and generates a valid uuid.
     *
     * @return void
     */
    public function testGetGenerator(): void
    {
        $uuid = $this->getManager()->getGenerator()->uuid4();

        $this->assertUuid4($uuid);
    }

    /**
     * Test that get marshaler return expected instance.
     *
     * @return void
     */
    public function testGetMarshaler(): void
    {
        $marshaler = $this->getManager()->getMarshaler();
        $item = $marshaler->marshalJson(\json_encode(['key1' => 'value1']) ?: '');

        self::assertSame([
            'key1' => [
                'S' => 'value1'
            ]
        ], $item);
    }

    /**
     * Ensure table names modified with prefix is indeed a prefix
     *
     * @return void
     */
    public function testTableFormatting(): void
    {
        $manager = new Manager(
            $this->getConnection($this->createMockHandler(), 'a-prefix-'),
            new UuidGeneratorStub()
        );

        $generatedTableName = $manager->getTableName('BigTable');

        self::assertSame('a-prefix-BigTable', $generatedTableName);
    }

    /**
     * Get manager.
     *
     * @param mixed[]|null $data Response data
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\ManagerInterface
     */
    private function getManager(?array $data = null): ManagerInterface
    {
        return new Manager(
            $this->getConnection($this->createMockHandler($data)),
            new UuidGeneratorStub()
        );
    }
}

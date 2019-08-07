<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use Aws\Command;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\MockHandler;
use Aws\Result;
use LoyaltyCorp\Auditing\Documents\AuditLog;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface;
use LoyaltyCorp\Auditing\Manager;
use LoyaltyCorp\Auditing\Managers\SchemaManager;
use LoyaltyCorp\Auditing\Services\Connection;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\UuidGeneratorStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Aws\DynamoDbClientExceptionStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Aws\DynamoDbDeleteTableExceptionStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Managers\SchemaManager
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) High coupling required for full testing.
 */
class SchemaManagerTest extends TestCase
{
    /**
     * Test create schema successfully.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $handler = new MockHandler();
        // listTables
        $handler->append(new Result([]));
        // createTable
        $handler->append(new Result());

        $manager = $this->getSchemaManager(null, $handler);
        $created = $manager->create(new AuditLog());

        self::assertTrue($created);
    }

    /**
     * Test create table exception is rethrown when it can't be handled.
     *
     * @return void
     */
    public function testCreateExceptionIsRethrownWhenItCantBeHandled(): void
    {
        $manager = $this->getSchemaManager(new Connection(
            new DynamoDbClientExceptionStub(
                new DynamoDbException(
                    'Connection not found.',
                    new Command('CreateTable')
                )
            )
        ));

        $this->expectException(DynamoDbException::class);

        $manager->create(new AuditLog());
    }

    /**
     * Test create on an existing table.
     *
     * @return void
     */
    public function testCreateOnExistingTable(): void
    {
        $handler = new MockHandler();
        // listTables
        $handler->append(new Result([
            'TableNames' => ['AuditLog']
        ]));
        // createTable
        $handler->append(new Result());

        $manager = $this->getSchemaManager(null, $handler);
        $created = $manager->create(new AuditLog());

        self::assertTrue($created);
    }

    /**
     * Test drop schema successfully.
     *
     * @return void
     */
    public function testDrop(): void
    {
        self::assertTrue($this->getSchemaManager()->drop(AuditLog::class));
    }

    /**
     * Test delete table exception is rethrown when it can't be handled.
     *
     * @return void
     */
    public function testDropExceptionIsRethrownWhenItCantBeHandled(): void
    {
        $manager = $this->getSchemaManager(new Connection(
            new DynamoDbClientExceptionStub(
                new DynamoDbException(
                    'Connection not found.',
                    new Command('DeleteTable')
                )
            )
        ));

        $this->expectException(DynamoDbException::class);

        $manager->drop(AuditLog::class);
    }

    /**
     * Test that deleting an existing table does not throw an exception.
     *
     * @return void
     */
    public function testDropOnNonExistingTable(): void
    {
        $manager = $this->getSchemaManager(new Connection(
            new DynamoDbClientExceptionStub(
                new DynamoDbDeleteTableExceptionStub()
            )
        ));

        $dropped = $manager->drop(AuditLog::class);

        self::assertTrue($dropped);
    }

    /**
     * Test that drop throws InvalidDocumentClassException when invalid class name is provided.
     *
     * @return void
     */
    public function testDropThrowsExceptionWhenInvalidClassNameProvided(): void
    {
        $this->expectException(InvalidDocumentClassException::class);
        $this->expectExceptionMessage(
            \sprintf('Provided document class (%s) is invalid or does not exist.', 'FakeClass')
        );

        $this->getSchemaManager()->drop('FakeClass');
    }

    /**
     * Test that drop throws InvalidDocumentClassException when invalid class type is provided.
     *
     * @return void
     */
    public function testDropThrowsExceptionWhenInvalidClassTypeProvided(): void
    {
        $this->expectException(InvalidDocumentClassException::class);
        $this->expectExceptionMessage(
            \sprintf('Provided document class (%s) is invalid or does not exist.', DtoStub::class)
        );

        $this->getSchemaManager()->drop(DtoStub::class);
    }

    /**
     * Get schema manager.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface|null $connection
     * @param \Aws\MockHandler|null $handler
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface
     */
    private function getSchemaManager(
        ?ConnectionInterface $connection = null,
        ?MockHandler $handler = null
    ): SchemaManagerInterface {
        return new SchemaManager(
            new Manager(
                $connection ?? $this->getConnection($handler),
                new UuidGeneratorStub()
            )
        );
    }
}

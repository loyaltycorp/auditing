<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Documents\AuditLog;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;
use LoyaltyCorp\Auditing\Managers\SchemaManager;
use Tests\LoyaltyCorp\Auditing\Stubs\DtoStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\UuidGeneratorStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Managers\SchemaManager
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
        self::assertTrue($this->getSchemaManager()->create(new AuditLog()));
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
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface
     */
    private function getSchemaManager(): SchemaManagerInterface
    {
        return new SchemaManager(
            $this->getConnection(),
            new UuidGeneratorStub()
        );
    }
}

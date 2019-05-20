<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Managers;

use LoyaltyCorp\Auditing\Entities\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;
use LoyaltyCorp\Auditing\Managers\Schema;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Manager
 * @covers \LoyaltyCorp\Auditing\Managers\Schema
 */
class SchemaTest extends TestCase
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
        self::assertTrue($this->getSchemaManager()->drop('AuditLog'));
    }

    /**
     * Get schema manager.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface
     */
    private function getSchemaManager(): SchemaInterface
    {
        return new Schema($this->getConnection($this->getMockHandler()));
    }
}

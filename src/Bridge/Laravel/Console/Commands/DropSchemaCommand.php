<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\Entities\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;

final class DropSchemaCommand extends Command
{
    /**
     * Construct drop schema command.
     */
    public function __construct()
    {
        $this->description = 'Drop DynamoDB schema';
        $this->signature = 'auditing:schema:drop';

        parent::__construct();
    }

    /**
     * Handle creation of auditing schema in DynamoDB.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface $schema
     */
    public function handle(SchemaInterface $schema): void
    {
        $schema->drop((new AuditLog())->getTableName());

        $this->warn('Audit schema dropped successfully!');
    }
}

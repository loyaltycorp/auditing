<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\Documents\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;

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
     * Handle dropping of auditing schema in DynamoDB.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface $schema
     *
     * @return void
     */
    public function handle(SchemaManagerInterface $schema): void
    {
        $schema->drop((new AuditLog())->getTableName());

        $this->warn('Audit schema dropped successfully!');
    }
}

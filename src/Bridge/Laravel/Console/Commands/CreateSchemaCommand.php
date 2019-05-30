<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\Documents\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface;

final class CreateSchemaCommand extends Command
{
    /**
     * Construct initialise audit scheam command.
     */
    public function __construct()
    {
        $this->description = 'Create DynamoDB schema for auditing';
        $this->signature = 'auditing:schema:create';

        parent::__construct();
    }

    /**
     * Handle creation of auditing schema in DynamoDB.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaManagerInterface $schema
     *
     * @return void
     */
    public function handle(SchemaManagerInterface $schema): void
    {
        $schema->create(new AuditLog());
        
        $this->info('Audit schema created successfully!');
    }
}

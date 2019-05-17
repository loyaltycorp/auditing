<?php 
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\Entities\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface;

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
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\SchemaInterface $schema
     */
    public function handle(SchemaInterface $schema): void
    {
        $schema->create(new AuditLog());
        
        $this->info('Audit schema created successfully!');
    }
}

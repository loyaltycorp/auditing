<?php 
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Illuminate\Console\Command;
use LoyaltyCorp\Auditing\DataTransferObjects\AuditLog as AuditLogDto;
use LoyaltyCorp\Auditing\Entities\AuditLog;
use LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface;
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
    public function handle(AuditorInterface $auditor, SchemaInterface $schema): void
    {
        $schema->create(new AuditLog());
        
        $this->info('Audit schema created successfully!');

        $auditor->log(new AuditLogDto(
            '963352e6-5f43-4c41-9f21-d688a5133b61',
            '2019-05-17 00:00:00'
        ));

        $this->info('Logged audit data successfully!');
    }
}

<?php 
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use Illuminate\Console\Command;

final class InitialiseAuditSchemaCommand extends Command
{
    /**
     * Construct initialise audit scheam command.
     */
    public function __construct()
    {
        $this->description = 'Initialise DynamoDB scheama for auditing';
        $this->signature = 'auditing:schema:create';

        parent::__construct();
    }

    /**
     * Handle creation of auditing schema in DynamoDB
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Audit schema created successfully!');
    }
}

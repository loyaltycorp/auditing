<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\SchemaManagerStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand
 */
class CreateSchemaCommandTest extends TestCase
{
    /**
     * Test command runs and returns a table
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testCommandRunsSuccessfully(): void
    {
        self::assertStringStartsWith('Audit schema created', $this->runCommand());
    }

    /**
     * Run command and return output
     *
     * @return string
     *
     * @throws \ReflectionException If class being reflected does not exist
     */
    private function runCommand(): string
    {
        $output = new BufferedOutput();

        // Run the command
        $this->createCommandInstance(CreateSchemaCommand::class, $output)->handle(new SchemaManagerStub());

        return $output->fetch();
    }
}

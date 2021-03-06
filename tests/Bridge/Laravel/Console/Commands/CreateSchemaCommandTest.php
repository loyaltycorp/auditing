<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\SchemaManagerStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Symfony\Component\Console\BufferedOutputStub;
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
        $output = new BufferedOutputStub();

        /** @var \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand $command */
        $command = $this->createCommandInstance(CreateSchemaCommand::class, $output);
        $command->handle(new SchemaManagerStub());

        return $output->fetch();
    }
}

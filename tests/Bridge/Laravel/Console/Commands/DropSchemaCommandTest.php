<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\SchemaStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand
 */
class DropSchemaCommandTest extends TestCase
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
        self::assertStringStartsWith('Audit schema dropped', $this->runCommand());
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
        $this->createCommandInstance(DropSchemaCommand::class, $output)->handle(new SchemaStub());

        return $output->fetch();
    }
}

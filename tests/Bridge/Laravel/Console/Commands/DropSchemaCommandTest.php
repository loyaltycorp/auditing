<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\DropSchemaCommand;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\SchemaManagerStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Symfony\Component\Console\BufferedOutputStub;
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
        $content = $this->runCommand();

        self::assertStringStartsWith('ATTENTION: This operation should not be executed', $content);
        self::assertStringContainsString('Audit schema dropped successfully!', $content);
    }

    /**
     * Test command runs and returns a table
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testCommandRunsSuccessfullyWhenNotConfirmed(): void
    {
        $content = $this->runCommand(false);

        self::assertStringStartsWith('ATTENTION: This operation should not be executed', $content);
        self::assertStringContainsString('No action taken', $content);
    }

    /**
     * Run command and return output
     *
     * @param bool|null $confirmYes
     *
     * @return string
     *
     * @throws \ReflectionException If class being reflected does not exist
     */
    private function runCommand(?bool $confirmYes = null): string
    {
        $output = new BufferedOutputStub(
            BufferedOutputStub::VERBOSITY_NORMAL,
            false,
            null,
            $confirmYes
        );

        // Run the command
        $this->createCommandInstance(DropSchemaCommand::class, $output)->handle(new SchemaManagerStub());

        return $output->fetch();
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands;

use LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\DispatcherStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Services\LogWriterStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand
 */
class LogUnindexedSearchItemCommandTest extends TestCase
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
        self::assertStringStartsWith('Writing logs to search queued for processing', $this->runCommand());
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

        /** @var \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\LogUnindexedSearchItemCommand $command */
        $command = $this->createCommandInstance(LogUnindexedSearchItemCommand::class, $output);
        $command->handle(new DispatcherStub(), new LogWriterStub());

        return $output->fetch();
    }
}

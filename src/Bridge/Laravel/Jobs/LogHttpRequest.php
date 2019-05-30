<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Jobs;

use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;

class LogHttpRequest extends Job
{
    /**
     * @var \LoyaltyCorp\Auditing\DataTransferObjects\LogLine
     */
    private $logLine;

    /**
     * LogHttpRequest constructor.
     *
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $logLine
     */
    public function __construct(LogLine $logLine)
    {
        $this->logLine = $logLine;
    }

    /**
     * Handball the given DTO deriving from a request into the log writer service
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface $logWriter
     *
     * @return void
     */
    public function handle(LogWriterInterface $logWriter): void
    {
        $logWriter->write($this->logLine);
    }
}

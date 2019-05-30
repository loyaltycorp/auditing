<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Jobs;

use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;

final class SearchLogWriterJob extends Job
{
    /**
     * Log line data transfer object.
     *
     * @var \LoyaltyCorp\Auditing\DataTransferObjects\LogLine
     */
    private $logLine;

    /**
     * Log line request id.
     *
     * @var string
     */
    private $requestId;

    /**
     * Construct search log writer.
     *
     * @param string $requestId
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $logLine
     */
    public function __construct(string $requestId, LogLine $logLine)
    {
        $this->requestId = $requestId;
        $this->logLine = $logLine;
    }

    /**
     * Handler search log writer job.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface $logWriter
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface $searchLogWriter
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle(
        LogWriterInterface $logWriter,
        SearchLogWriterInterface $searchLogWriter
    ): void {
        $data = [
            \array_merge($this->logLine->toArray(), ['requestId' => $this->requestId])
        ];

        $searchLogWriter->bulkWrite($data);

        $logWriter->update($this->requestId, new LogLine(
            $this->logLine->getClientIp(),
            LogLine::LINE_STATUS_INDEXED,
            $this->logLine->getOccurredAt(),
            $this->logLine->getRequestData(),
            $this->logLine->getResponseData()
        ));
    }
}

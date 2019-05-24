<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;

interface LogWriterInterface
{
    /**
     * Write log line.
     *
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $dataObject
     *
     * @return void
     */
    public function write(LogLine $dataObject): void;

    /**
     * List log lines by line status.
     *
     * @param int $lineStatus
     *
     * @return mixed[]
     */
    public function listByLineStatus(int $lineStatus): array;

    /**
     * Write log line.
     *
     * @param string $requestId Log line request id
     * @param \LoyaltyCorp\Auditing\DataTransferObjects\LogLine $dataObject
     *
     * @return void
     */
    public function update(string $requestId, LogLine $dataObject): void;
}

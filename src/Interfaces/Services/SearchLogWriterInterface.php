<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

interface SearchLogWriterInterface
{
    /**
     * Write log line to search log.
     *
     * @param mixed[] $logLines
     *
     * @return void
     */
    public function bulkWrite(array $logLines): void;
}

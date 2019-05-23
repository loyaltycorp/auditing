<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;

interface LogWriterInterface
{
    /**
     * Write log data.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject
     *
     * @return void
     */
    public function write(DataObjectInterface $dataObject): void;

    /**
     * List log lines by line status.
     *
     * @param int $lineStatus
     *
     * @return \LoyaltyCorp\Auditing\DataTransferObjects\LogLine[]
     */
    public function listByLineStatus(int $lineStatus): array;
}

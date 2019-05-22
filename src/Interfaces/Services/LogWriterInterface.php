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
     * @return \Aws\Result
     */
    public function write(DataObjectInterface $dataObject): Result;

    /**
     * List log lines by line status.
     *
     * @param int $lineStatus
     *
     * @return \Aws\Result
     */
    public function listByLineStatus(int $lineStatus): Result;
}
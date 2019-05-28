<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\DataTransferObjects;

interface LogLineInterface
{
    /**
     * Status for indexed log line.
     *
     * @const int
     */
    public const LINE_STATUS_INDEXED = 1;

    /**
     * Status for un-indexed log line.
     *
     * @const int
     */
    public const LINE_STATUS_NOT_INDEXED = 0;
}

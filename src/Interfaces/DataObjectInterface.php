<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface DataObjectInterface
{
    /**
     * Get table name.
     *
     * @return string
     */
    public function getTableName(): string;

    /**
     * Serialise data transfer object to array.
     *
     * @return mixed[]
     */
    public function toArray(): array;
}

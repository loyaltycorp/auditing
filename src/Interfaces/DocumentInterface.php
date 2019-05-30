<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface DocumentInterface
{
    /**
     * Get schema name.
     *
     * @return string
     */
    public function getTableName(): string;

    /**
     * Serialise schema entity to array.
     *
     * @return mixed[]
     */
    public function toArray(): array;
}

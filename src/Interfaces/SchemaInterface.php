<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface SchemaInterface
{
    /**
     * Create audit schema.
     *
     * @return boolean
     */
    public function create(): bool;
}

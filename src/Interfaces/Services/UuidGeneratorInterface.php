<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

interface UuidGeneratorInterface
{
    /**
     * Generate UUID v4.
     *
     * @return string Uuid
     */
    public function uuid4(): string;
}

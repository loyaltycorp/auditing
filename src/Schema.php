<?php 
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use LoyaltyCorp\Auditing\Interfaces\SchemaInterface;

final class Schema implements SchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(): bool
    {
        return true;
    }
}

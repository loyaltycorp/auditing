<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;

/**
 * @coversNothing
 */
class UuidGeneratorStub implements UuidGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function uuid4(): string
    {
        return 'b5c73861-8207-40d5-83fe-889e1b4fd7fe';
    }
}

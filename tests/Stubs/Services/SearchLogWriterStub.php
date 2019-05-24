<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;

/**
 * @coversNothing
 */
class SearchLogWriterStub implements SearchLogWriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function bulkWrite(array $logLines): void
    {
    }
}

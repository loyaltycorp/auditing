<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Client;

use LoyaltyCorp\Auditing\Client\SearchClient;

/**
 * @coversNothing
 */
class SearchClientStub extends SearchClient
{
    /**
     * {@inheritdoc}
     */
    public function bulkDelete(array $searchIds): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bulkUpdate(string $index, array $documents): void
    {
    }
}

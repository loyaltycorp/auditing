<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Client;

use LoyaltyCorp\Search\Interfaces\ClientInterface;

/**
 * @coversNothing
 */
class SearchClientStub implements ClientInterface
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

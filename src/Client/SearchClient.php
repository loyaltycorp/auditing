<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Client;

use LoyaltyCorp\Search\Interfaces\ClientInterface;

class SearchClient implements ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function bulkDelete(array $searchIds): void
    {
        // TODO: Implement bulkDelete() method.
    }

    /**
     * {@inheritdoc}
     */
    public function bulkUpdate(string $index, array $documents): void
    {
        // TODO: Implement bulkUpdate() method.
    }
}

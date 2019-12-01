<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate;
use LoyaltyCorp\Search\Interfaces\ClientInterface;

final class SearchLogWriter implements SearchLogWriterInterface
{
    /**
     * Search client.
     *
     * @var \LoyaltyCorp\Search\Interfaces\ClientInterface
     */
    private $searchClient;

    /**
     * Construct search log writer.
     *
     * @param \LoyaltyCorp\Search\Interfaces\ClientInterface $searchClient
     */
    public function __construct(ClientInterface $searchClient)
    {
        $this->searchClient = $searchClient;
    }

    /**
     * {@inheritdoc}
     */
    public function bulkWrite(array $logLines): void
    {
        $documents = [];

        foreach ($logLines as $logLine) {
            $documents[] = new DocumentUpdate(
                'http-requests',
                $logLine['requestId'],
                $logLine
            );
        }

        $this->searchClient->bulkUpdate($documents);
    }
}

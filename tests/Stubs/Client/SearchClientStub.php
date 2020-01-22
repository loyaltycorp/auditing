<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Client;

use LoyaltyCorp\Search\DataTransferObjects\ClusterHealth;
use LoyaltyCorp\Search\Interfaces\ClientInterface;

/**
 * @coversNothing
 */
class SearchClientStub implements ClientInterface
{
    /**
     * @var \LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate[][]
     */
    private $updates;

    /**
     * {@inheritdoc}
     */
    public function bulkDelete(array $searchIds): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bulkUpdate(array $documents): void
    {
        $this->updates[] = $documents;
    }

    /**
     * {@inheritdoc}
     */
    public function count(string $index): int
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createAlias(string $indexName, string $aliasName): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex(string $name, ?array $mappings = null, ?array $settings = null): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAlias(array $aliases): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function deleteIndex(string $name): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(?string $name = null): array
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getHealth(): ClusterHealth
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getIndices(?string $name = null): array
    {
    }

    /**
     * @return \LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate[][]
     */
    public function getUpdates(): array
    {
        return $this->updates;
    }

    /**
     * {@inheritdoc}
     */
    public function isAlias(string $name): bool
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isIndex(string $name): bool
    {
    }

    /**
     * {@inheritdoc}
     */
    public function moveAlias(array $aliases): void
    {
    }
}

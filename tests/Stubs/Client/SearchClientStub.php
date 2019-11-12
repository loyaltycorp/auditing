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
    public function getIndices(?string $name = null): array
    {
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

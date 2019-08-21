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
     * Create a new alias for specified index
     *
     * @param string $indexName
     * @param string $aliasName
     *
     * @return void
     */
    public function createAlias(string $indexName, string $aliasName): void
    {
        // TODO: Implement createAlias() method.
    }

    /**
     * Create a new index
     *
     * @param string $name
     * @param mixed[]|null $mappings
     * @param mixed[]|null $settings
     *
     * @return void
     */
    public function createIndex(string $name, ?array $mappings = null, ?array $settings = null): void
    {
        // TODO: Implement createIndex() method.
    }

    /**
     * Delete an existing alias across all indices
     *
     * @param string[] $aliases Array of alias names to be deleted
     *
     * @return void
     */
    public function deleteAlias(array $aliases): void
    {
        // TODO: Implement deleteAlias() method.
    }

    /**
     * Delete an existing index
     *
     * @param string $name
     *
     * @return void
     */
    public function deleteIndex(string $name): void
    {
        // TODO: Implement deleteIndex() method.
    }

    /**
     * List all existing aliases
     *
     * @param string|null $name
     *
     * @return string[][]
     */
    public function getAliases(?string $name = null): array
    {
        // TODO: Implement getAliases() method.
    }

    /**
     * List all existing indexes
     *
     * @param string|null $name
     *
     * @return mixed[]
     */
    public function getIndices(?string $name = null): array
    {
        // TODO: Implement getIndices() method.
    }

    /**
     * Determine if alias exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function isAlias(string $name): bool
    {
        // TODO: Implement isAlias() method.
    }

    /**
     * Determine if index exists
     *
     * @param string $name
     *
     * @return bool
     */
    public function isIndex(string $name): bool
    {
        // TODO: Implement isIndex() method.
    }

    /**
     * Atomically remove/add alias
     *
     * @param string[][] $aliases Array containing alias and index to be swapped
     *
     * @return void
     */
    public function moveAlias(array $aliases): void
    {
        // TODO: Implement moveAlias() method.
    }
}

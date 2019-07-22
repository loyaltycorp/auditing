<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

interface ConnectionFactoryInterface
{
    /**
     * Create a DynamoDb client instance
     *
     * @param string $region
     * @param string|null $version
     * @param mixed[]|null $additional
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface
     */
    public function create(
        string $region,
        ?string $version = null,
        ?array $additional = null
    ): ConnectionInterface;
}

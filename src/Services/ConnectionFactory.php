<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use Aws\DynamoDb\DynamoDbClient;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionFactoryInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\ConnectionInterface;

class ConnectionFactory implements ConnectionFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(
        string $region,
        ?string $tablePrefix = null,
        ?string $version = null,
        ?array $additional = null
    ): ConnectionInterface {
        $configuration = \array_merge(
            [
                'region' => $region,
                'version' => $version ?? 'latest'
            ],
            // Additional keys take precedence over above
            $additional ?? []
        );

        return new Connection(new DynamoDbClient($configuration), $tablePrefix);
    }
}

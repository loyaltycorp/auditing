<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Client;

use Aws\DynamoDb\DynamoDbClient;
use Countable;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;

final class Connection implements ConnectionInterface
{
    /**
     * AWS DynamoDB client.
     *
     * @var \Aws\DynamoDb\DynamoDbClient
     */
    private $dbClient;

    /**
     * Construct AWS DynamoDb connection.
     *
     * @param string $key AWS access key id
     * @param string $secret AWS secret access key
     * @param string $region AWS region
     * @param string|null $endpoint Endpoint url
     * @param string|null $version Version
     * @param \Countable|null $handler Custom handler
     */
    public function __construct(
        string $key,
        string $secret,
        string $region,
        ?string $endpoint = null,
        ?string $version = null,
        ?Countable $handler = null
    ) {
        $this->dbClient = new DynamoDbClient(\array_merge([
            'credentials' => [
                'key' => $key,
                'secret' => $secret
            ],
            'endpoint' => $endpoint,
            'region' => $region,
            'version' => $version ?? 'latest'
        ], $handler !== null ? ['handler' => $handler] : []));
    }

    /**
     * {@inheritdoc}
     */
    public function getDbClient(): DynamoDbClient
    {
        return $this->dbClient;
    }
}

<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Client;

use Aws\DynamoDb\DynamoDbClient;
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
     * @param mixed[]|null $additional Additional AWS client arguments
     */
    public function __construct(
        string $key,
        string $secret,
        string $region,
        ?string $endpoint = null,
        ?string $version = null,
        ?array $additional = null
    ) {
        $this->dbClient = new DynamoDbClient(\array_merge(
            $additional ?? [],
            [
                'credentials' => [
                    'key' => $key,
                    'secret' => $secret
                ],
                'endpoint' => $endpoint,
                'region' => $region,
                'version' => $version ?? 'latest'
            ]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getDbClient(): DynamoDbClient
    {
        return $this->dbClient;
    }
}

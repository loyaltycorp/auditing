<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use Aws\DynamoDb\DynamoDbClient;
use LoyaltyCorp\Auditing\Services\ConnectionFactory;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\ConnectionFactory
 */
class ConnectionFactoryTest extends TestCase
{
    /**
     * Various inputs for creating a connection from the factory
     *
     * @return iterable|mixed[]
     */
    public function getInputForCreation(): iterable
    {
        yield 'credentials supplied' => [
            'region' => 'ap-southeast-2',
            'version' => 'latest',
            'additionalArguments' => [
                [
                    'credentials' => [
                        'key' => 'key1',
                        'secret' => 'secret2'
                    ]
                ]
            ],
            'expectedDynamoDbClient' => new DynamoDbClient([
                'region' => 'ap-southeast-2',
                'version' => 'latest',
                'credentials' => ['key' => 'key1', 'secret' => 'secret2']
            ])
        ];

        yield 'credentials missing (assume IAM role)' => [
            'region' => 'ap-southeast-2',
            'version' => 'latest',
            'additionalArguments' => [],
            'expectedDynamoDbClient' => new DynamoDbClient([
                'region' => 'ap-southeast-2',
                'version' => 'latest'
            ])
        ];
    }

    /**
     * Ensure the connection factory creates an AWS DynamoDb client with expected configuration
     *
     * @param string $region
     * @param string|null $version
     * @param mixed[]|null $additional
     * @param \Aws\DynamoDb\DynamoDbClient $expectedClient
     *
     * @return void
     *
     * @dataProvider getInputForCreation()
     */
    public function testCreating(
        string $region,
        ?string $version,
        ?array $additional,
        DynamoDbClient $expectedClient
    ): void {
        $connectionFactory = $this->createInstance();

        $resultClient = $connectionFactory->create(
            $region,
            $version,
            $additional
        );

        self::assertEquals($expectedClient, $resultClient->getClient());
    }

    /**
     * Instantiate a new connection class
     *
     * @return \LoyaltyCorp\Auditing\Services\ConnectionFactory
     */
    private function createInstance(): ConnectionFactory
    {
        return new ConnectionFactory();
    }
}

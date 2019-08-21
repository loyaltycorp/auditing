<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services\Search;

use LoyaltyCorp\Auditing\Services\Search\AuditingSearchHandler;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\Search\AuditingSearchHandler
 */
class AuditingSearchHandlerTest extends TestCase
{
    /**
     * Test index name.
     *
     * @return void
     */
    public function testIndexName(): void
    {
        $handler = new AuditingSearchHandler();

        $indexName = $handler->getIndexName();

        self::assertSame('http-requests', $indexName);
    }

    /**
     * Test mappings are known.
     *
     * @return void
     */
    public function testMappings(): void
    {
        $expected = [
            'doc' => [
                'dynamic' => 'strict',
                'properties' => [
                    'clientIp' => ['type' => 'keyword'],
                    'lineStatus' => ['type' => 'integer'],
                    'occurredAt' => ['type' => 'date'],
                    'requestData' => ['type' => 'text'],
                    'responseData' => ['type' => 'text'],
                    'requestId' => ['type' => 'keyword']
                ]
            ]
        ];

        $handler = new AuditingSearchHandler();

        self::assertSame($expected, $handler::getMappings());
    }

    /**
     * Test settings are known.
     *
     * @return void
     */
    public function testSettings(): void
    {
        $expected = [
            'number_of_replicas' => 1,
            'number_of_shards' => 1
        ];

        $handler = new AuditingSearchHandler();

        self::assertSame($expected, $handler::getSettings());
    }
}

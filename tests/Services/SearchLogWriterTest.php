<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;
use Tests\LoyaltyCorp\Auditing\Stubs\Client\SearchClientStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\SearchLogWriter
 */
class SearchLogWriterTest extends TestCase
{
    /**
     * Test bulk write to search log successfully.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBulkWrite(): void
    {
        $this->getService()->bulkWrite([[
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'requestData' => '{"send": "me"}',
            'requestId' => 'request-id',
            'responseData' => '{"status": "ok"}'
        ]]);

        $this->addToAssertionCount(1);
    }

    /**
     * Get search log writer service.
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\SearchLogWriterInterface
     */
    private function getService(): SearchLogWriterInterface
    {
        return new SearchLogWriter(new SearchClientStub());
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use EoneoPay\Utils\DateTime;
use LoyaltyCorp\Auditing\Services\SearchLogWriter;
use LoyaltyCorp\Search\DataTransferObjects\DocumentUpdate;
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
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testBulkWrite(): void
    {
        $searchClient = new SearchClientStub();
        $searchLogWriter = new SearchLogWriter($searchClient);

        $line = [
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new DateTime())->format('Y-m-d H:i:s'),
            'requestData' => '{"send": "me"}',
            'requestId' => 'request-id',
            'responseData' => '{"status": "ok"}'
        ];

        $expected = [
            new DocumentUpdate(
                'http-requests',
                'request-id',
                [
                    'clientIp' => '127.0.01',
                    'lineStatus' => 1,
                    'occurredAt' => (new DateTime())->format('Y-m-d H:i:s'),
                    'requestData' => '{"send": "me"}',
                    'requestId' => 'request-id',
                    'responseData' => '{"status": "ok"}'
                ]
            )
        ];

        $searchLogWriter->bulkWrite([$line]);

        self::assertEquals([$expected], $searchClient->getUpdates());
    }

    /**
     * Test bulk write to search log successfully for Provider Aware logs.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testBulkWriteProviderAware(): void
    {
        $searchClient = new SearchClientStub();
        $searchLogWriter = new SearchLogWriter($searchClient);
        $occurredAt = '2018-03-22 13:45:56';

        $line = [
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => $occurredAt,
            'providerId' => 'PROV--ABC123',
            'requestData' => '{"help": "me"}',
            'requestId' => 'ReqId-Test-1111',
            'responseData' => '{"abc": [1,2,3,4,5,7]}'
        ];

        $expected = [
            new DocumentUpdate(
                'http-requests_PROV--ABC123',
                'ReqId-Test-1111',
                [
                    'clientIp' => '127.0.01',
                    'lineStatus' => 1,
                    'occurredAt' => $occurredAt,
                    'requestData' => '{"help": "me"}',
                    'requestId' => 'ReqId-Test-1111',
                    'responseData' => '{"abc": [1,2,3,4,5,7]}'
                ]
            )
        ];

        $searchLogWriter->bulkWrite([$line]);

        self::assertEquals([$expected], $searchClient->getUpdates());
    }
}

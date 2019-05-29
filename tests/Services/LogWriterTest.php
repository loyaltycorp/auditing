<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use EoneoPay\Utils\Interfaces\UtcDateTimeInterface;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;
use LoyaltyCorp\Auditing\Services\LogWriter;
use Tests\LoyaltyCorp\Auditing\Stubs\Managers\DocumentManagerStub;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\LogWriter
 */
class LogWriterTest extends TestCase
{
    /**
     * Test list logs items by line status returns expected number of results.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testListByLineStatusSuccessfully(): void
    {
        $manager = new DocumentManagerStub([[
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'requestData' => '{"send": "me"}',
            'responseData' => '{"status": "ok"}'
        ]]);

        $result = $this->getService($manager)->listByLineStatus(1);

        self::assertCount(1, $result);
    }

    /**
     * Test write log successfully.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWriteSuccessfully(): void
    {
        $expected = [
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format(UtcDateTimeInterface::FORMAT_ZULU),
            'requestData' => '{"send": "me"}',
            'responseData' => '{"status": "ok"}'
        ];
        $manager = new DocumentManagerStub();

        $this->getService($manager)->write(new LogLine(
            '127.0.01',
            1,
            new \DateTime(),
            '{"send": "me"}',
            '{"status": "ok"}'
        ));

        self::assertSame($expected, $manager->results);
    }

    /**
     * Test update log data successfully.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testUpdateSuccessfully(): void
    {
        $expected = [
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format(UtcDateTimeInterface::FORMAT_ZULU),
            'requestData' => '{"send": "me"}',
            'responseData' => '{"status": "ok"}'
        ];
        $manager = new DocumentManagerStub();

        $this->getService($manager)->update('request-id', new LogLine(
            '127.0.01',
            1,
            new \DateTime(),
            '{"send": "me"}',
            '{"status": "ok"}'
        ));

        self::assertSame($expected, $manager->results);
    }

    /**
     * Get log writer service.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface|null $manager
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface
     */
    private function getService(?DocumentManagerInterface $manager = null): LogWriterInterface
    {
        $manager = $manager ?? new DocumentManagerStub();

        return new LogWriter($manager);
    }
}

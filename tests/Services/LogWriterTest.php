<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
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
        $result = $this->getService([[
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'requestData' => '{"send": "me"}',
            'responseData' => '{"status": "ok"}'
        ]])->listByLineStatus(1);

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
        $this->getService()->write(new LogLine(
            '127.0.01',
            1,
            new \DateTime(),
            '{"send": "me"}',
            '{"status": "ok"}'
        ));

        $this->addToAssertionCount(1);
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
        $this->getService()->update('request-id', new LogLine(
            '127.0.01',
            1,
            new \DateTime(),
            '{"send": "me"}',
            '{"status": "ok"}'
        ));

        $this->addToAssertionCount(1);
    }

    /**
     * Get log writer service.
     *
     * @param mixed[]|null $results Result data
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface
     */
    private function getService(?array $results = null): LogWriterInterface
    {
        return new LogWriter(new DocumentManagerStub($results));
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;

/**
 * @coversNothing
 */
class LogWriterStub implements LogWriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(LogLine $dataObject): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function listByLineStatus(int $lineStatus): array
    {
        return [[
            'clientIp' => '127.0.01',
            'lineStatus' => 1,
            'occurredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'requestData' => '{"send": "me"}',
            'requestId' => 'request-id',
            'responseData' => '{"status": "ok"}'

        ]];
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $requestId, LogLine $dataObject): void
    {
    }
}

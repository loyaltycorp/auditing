<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LogLineFactoryStub implements LogLineFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): LogLine {
        return new LogLine(
            $ipAddress,
            $now,
            $request->getBody()->getContents(),
            $response instanceof ResponseInterface ? $response->getBody()->getContents() : null,
            0
        );
    }
}

<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Services;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface LogLineFactoryInterface
{
    /**
     * Create a new log line object
     *
     * @param string $ipAddress
     * @param \DateTime $now
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     *
     * @return \LoyaltyCorp\Auditing\DataTransferObjects\LogLine
     */
    public function create(
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): LogLine;
}

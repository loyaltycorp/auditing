<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces;

use DateTime;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpLoggerInterface
{
    /**
     * Record the provided parameters as a request
     *
     * @param string $ipAddress
     * @param \DateTime $now
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     *
     * @return void
     */
    public function record(
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void;
}

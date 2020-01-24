<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces;

use DateTime;
use LoyaltyCorp\Multitenancy\Database\Entities\Provider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface HttpLoggerInterface
{
    /**
     * Record the provided parameters as a request
     *
     * @param \LoyaltyCorp\Multitenancy\Database\Entities\Provider|null $provider
     * @param string $ipAddress
     * @param \DateTime $now
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface|null $response
     *
     * @return void
     */
    public function record(
        ?Provider $provider,
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void;
}

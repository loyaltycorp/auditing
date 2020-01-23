<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services;

use DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Multitenancy\Database\Entities\Provider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversNothing
 */
class HttpLoggerStub implements HttpLoggerInterface
{
    /**
     * @var string|null
     */
    private $ipAddress;

    /**
     * @var \DateTime|null
     */
    private $now;

    /**
     * @var \LoyaltyCorp\Multitenancy\Database\Entities\Provider|null
     */
    private $provider;

    /**
     * @var \Psr\Http\Message\RequestInterface|null
     */
    private $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    private $response;

    /**
     * Get IP address that was passed to the logger
     *
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * Get datetime that was passed to the logger
     *
     * @return \DateTime|null
     */
    public function getNow(): ?DateTime
    {
        return $this->now;
    }

    /**
     * Get provider.
     *
     * @return \LoyaltyCorp\Multitenancy\Database\Entities\Provider|null
     */
    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    /**
     * Get PSR request that was passed to the logger
     *
     * @return \Psr\Http\Message\RequestInterface|null
     */
    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    /**
     * Get PSR7 response that was passed to the logger
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function record(
        ?Provider $provider,
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void {
        $this->provider = $provider;
        $this->request = $request;
        $this->ipAddress = $ipAddress;
        $this->now = $now;
        $this->response = $response;
    }
}

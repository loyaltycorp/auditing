<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services;

use DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversNothing
 */
class HttpLoggerStub implements HttpLoggerInterface
{
    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var \DateTime
     */
    private $now;

    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    private $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    public function record(
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void {

        $this->request = $request;
        $this->ipAddress = $ipAddress;
        $this->now = $now;
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return \DateTime
     */
    public function getNow(): \DateTime
    {
        return $this->now;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}

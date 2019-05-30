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
     * @var string|null
     */
    private $ipAddress;

    /**
     * @var \DateTime|null
     */
    private $now;

    /**
     * @var \Psr\Http\Message\RequestInterface|null
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
}

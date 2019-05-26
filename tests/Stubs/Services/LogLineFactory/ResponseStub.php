<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @coversNothing
 */
class ResponseStub implements ResponseInterface
{
    /**
     * @var int
     */
    private $contentSize;

    /**
     * RequestStub constructor.
     *
     * @param int|null $contentSize
     */
    public function __construct(?int $contentSize = null)
    {
        // Default to 1000 bytes
        $this->contentSize = $contentSize ?? 1000;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return new StreamStub($this->contentSize);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
    }
}

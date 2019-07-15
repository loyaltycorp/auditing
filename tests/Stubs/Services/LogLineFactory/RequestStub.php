<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\Uri;

/**
 * @coversNothing
 */
class RequestStub implements RequestInterface
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
        return ['key' => ['value']];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
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
    public function getRequestTarget()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUri()
    {
        return new Uri('http::/localhost');
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
    public function withMethod($method)
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
    public function withRequestTarget($requestTarget)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag) External interface
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
    }
}

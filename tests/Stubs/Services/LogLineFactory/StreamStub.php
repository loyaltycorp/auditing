<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services\LogLineFactory;

use Psr\Http\Message\StreamInterface;

/**
 * @coversNothing
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods) Inherited methods from external interface
 */
class StreamStub implements StreamInterface
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
    public function __toString()
    {
        return $this->getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        return \str_pad(
            '',
            $this->contentSize,
            '0'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        return \str_pad(
            '',
            $length,
            '0'
        );
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
    }

    /**
     * Seek
     *
     * @param mixed $offset
     * @param mixed $whence
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Inherited from external interface
     */
    public function seek($offset, $whence = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
    }
}

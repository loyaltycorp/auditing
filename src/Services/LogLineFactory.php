<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class LogLineFactory implements LogLineFactoryInterface
{
    /**
     * @const int Maximum number of bytes that should be read
     */
    private const MAX_CONTENT_BYTES = 100000;

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
            0,
            $now,
            $this->getStreamContentTruncated($request->getBody()),
            $response instanceof ResponseInterface ? $this->getStreamContentTruncated($response->getBody()) : null
        );
    }

    /**
     * Truncate the http body to avoid potential memory DoS
     *
     * @param \Psr\Http\Message\StreamInterface $stream
     *
     * @return string
     */
    private function getStreamContentTruncated(StreamInterface $stream): string
    {
        return $stream->read(static::MAX_CONTENT_BYTES);
    }
}

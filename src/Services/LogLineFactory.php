<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use DateTime;
use GuzzleHttp\Psr7;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Interfaces\DataTransferObjects\LogLineInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
        $requestString = Psr7\str($request);
        $responseString =  $response instanceof ResponseInterface ? Psr7\str($response) : null;

        return new LogLine(
            $ipAddress,
            LogLineInterface::LINE_STATUS_NOT_INDEXED,
            $now,
            $this->getContentTruncated($requestString),
            $this->getContentTruncated($responseString)
        );
    }

    /**
     * Truncate the message to avoid potential memory DoS.
     *
     * @param string $message Http request/response as string
     *
     * @return string Truncated message
     */
    private function getContentTruncated(?string $message = null): ?string
    {
        if ($message === null) {
            return null;
        }

        return \mb_substr($message, 0, static::MAX_CONTENT_BYTES);
    }
}

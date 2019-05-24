<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Services;

use DateTime;
use Illuminate\Contracts\Bus\Dispatcher as IlluminateJobDispatcher;
use LoyaltyCorp\Auditing\Bridge\Laravel\Jobs\LogHttpRequest;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpLogger implements HttpLoggerInterface
{
    /**
     * @var \Illuminate\Contracts\Bus\Dispatcher
     */
    private $dispatcher;

    /**
     * @var \LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface
     */
    private $logLineFactory;

    /**
     * HttpLogger constructor.
     *
     * @param \Illuminate\Contracts\Bus\Dispatcher $dispatcher
     * @param \LoyaltyCorp\Auditing\Interfaces\Services\LogLineFactoryInterface $logLineFactory
     */
    public function __construct(IlluminateJobDispatcher $dispatcher, LogLineFactoryInterface $logLineFactory)
    {
        $this->dispatcher = $dispatcher;
        $this->logLineFactory = $logLineFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function record(
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void {
        // Build the DTO
        $logLine = $this->logLineFactory->create($ipAddress, $now, $request, $response);

        // Dispatch the HTTP log job
        $this->dispatcher->dispatch(
            new LogHttpRequest($logLine)
        );
    }
}

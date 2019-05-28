<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares;

use Closure;
use EoneoPay\Externals\Logger\Interfaces\LoggerInterface;
use EoneoPay\Utils\DateTime;
use Exception;
use Illuminate\Http\Request;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    /**
     * @var \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface
     */
    private $httpLogger;

    /**
     * @var \EoneoPay\Externals\Logger\Interfaces\LoggerInterface
     */
    private $logger;

    /**
     * @var \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface
     */
    private $psr7Factory;

    /**
     * AuditMiddleware constructor.
     *
     * @param \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface $httpLogger
     * @param \EoneoPay\Externals\Logger\Interfaces\LoggerInterface $logger
     * @param \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface $psr7Factory
     */
    public function __construct(
        HttpLoggerInterface $httpLogger,
        LoggerInterface $logger,
        HttpMessageFactoryInterface $psr7Factory
    ) {
        $this->httpLogger = $httpLogger;
        $this->logger = $logger;
        $this->psr7Factory = $psr7Factory;
    }

    /**
     * Handle the request and response and convert them to psr7 to be logged
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $datetime = new DateTime();
        $originalException = null;
        $response = null;

        try {
            $response = $next($request);
        } catch (Exception $exception) {
            $originalException = $exception;
        }

        $this->processForLogging($datetime, $request, $response);

        // if there has been a original exception in the $next, throw it again here
        if (($originalException instanceof Exception) === true) {
            throw $originalException;
        }

        return $response;
    }

    /**
     * Call the HttpLoggerInterface to log psr request and response
     *
     * @param \EoneoPay\Utils\DateTime $datetime
     * @param string $ipAddress
     * @param \Psr\Http\Message\RequestInterface|null $psrRequest
     * @param \Psr\Http\Message\ResponseInterface|null $psrResponse
     *
     * @return void
     */
    private function callHttpLogger(
        DateTime $datetime,
        string $ipAddress,
        ?RequestInterface $psrRequest,
        ?ResponseInterface $psrResponse = null
    ): void {
        try {
            if (($psrRequest instanceof RequestInterface) === true) {
                $this->httpLogger->record(
                    $ipAddress,
                    $datetime,
                    $psrRequest,
                    $psrResponse
                );
            }
        } catch (Exception $exception) {
            $this->logger->exception($exception);
        }
    }

    /**
     * Convert symfony request to PSR7 request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Psr\Http\Message\RequestInterface|null
     */
    private function createPsr7Request(Request $request): ?RequestInterface
    {
        $psrRequest = null;
        try {
            $psrRequest = $this->psr7Factory->createRequest($request);
        } catch (Exception $exception) {
            $this->logger->exception($exception);
        }

        return $psrRequest;
    }

    /**
     * Convert symfony response to PSR7 response
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    private function createPsr7Response(Response $response): ?ResponseInterface
    {
        $psrResponse = null;

        try {
            $psrResponse = $this->psr7Factory->createResponse($response);
        } catch (Exception $exception) {
            $this->logger->exception($exception);
        }

        return $psrResponse;
    }

    /**
     * @param \EoneoPay\Utils\DateTime $dateTime
     * @param \Illuminate\Http\Request $request
     * @param \Symfony\Component\HttpFoundation\Response|\Psr\Http\Message\ResponseInterface|null $response
     *
     * @return void
     */
    private function processForLogging(
        DateTime $dateTime,
        Request $request,
        $response = null
    ): void {
        $psrRequest = $this->createPsr7Request($request);

        $psrResponse = null;
        if (($response instanceof Response) === true) {
            $psrResponse = $this->createPsr7Response($response);
        }

        // if response is already an instance of psr7
        if (($response instanceof ResponseInterface) === true) {
            $psrResponse = $response;
        }

        $this->callHttpLogger($dateTime, $request->ip() ?? '', $psrRequest, $psrResponse);
    }
}

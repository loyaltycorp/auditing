<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares;

use Closure;
use EoneoPay\Utils\DateTime;
use Illuminate\Http\Request;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    /**
     * @var \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface
     */
    private $httpLogger;

    /**
     * @var \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface
     */
    private $psr7Factory;

    /**
     * AuditMiddleware constructor.
     *
     * @param \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface $httpLogger
     * @param \Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface $psr7Factory
     */
    public function __construct(
        HttpLoggerInterface $httpLogger,
        HttpMessageFactoryInterface $psr7Factory
    ) {
        $this->httpLogger = $httpLogger;
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
     */
    public function handle(Request $request, Closure $next)
    {
        $datetime = new DateTime();
        try {
            $response = $next($request);
        } catch (\Exception $exception) {
            // TODO: returning null until a decision is made on how to handle exceptions
            $response = null;
        }

        $psrRequest = $this->createPsr7Request($request);
        $psrResponse = null;
        if (($response instanceof Response) === true) {
            $psrResponse = $this->createPsr7Response($response);
        }

        // if response is already an instance of psr7 response
        if (($response instanceof ResponseInterface) === true) {
            $psrResponse = $response;
        }

        // TODO: space to plug in service (PYMT-713) and use $psrRequest and $psrResponse
        $this->httpLogger->record(
            $request->ip() ?? '',
            $datetime,
            $psrRequest,
            $psrResponse
        );

        return $response;
    }

    /**
     * Convert symfony request to PSR7 request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    private function createPsr7Request(Request $request): ServerRequestInterface
    {
        return $this->psr7Factory->createRequest($request);
    }

    /**
     * Convert symfony response to PSR7 response
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function createPsr7Response(Response $response): ResponseInterface
    {
        return $this->psr7Factory->createResponse($response);
    }
}

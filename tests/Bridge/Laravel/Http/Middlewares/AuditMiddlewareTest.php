<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares;

use EoneoPay\Externals\Logger\Logger;
use EoneoPay\Utils\DateTime;
use Illuminate\Http\Request;
use LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services\HttpLoggerExceptionStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services\HttpLoggerStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Monolog\Handler\LogHandlerStub;
use Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Symfony\HttpFoundation\ResponseStub;
use Tests\LoyaltyCorp\Auditing\TestCase;
use Zend\Diactoros\Response\TextResponse;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Requires many classes for full testing
 */
class AuditMiddlewareTest extends TestCase
{
    /**
     * Test basic handle function
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandle(): void
    {
        $middleware = $this->getMiddleware();

        $response = $middleware->handle(
            $this->getRequest(),
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertSame('OK', $response->getContent());
    }

    /**
     * Test if handle can catch the exceptions and continue processing
     * and rethrow exception at end
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandleHandlesExceptionsAndRethrows(): void
    {
        $this->expectException(InvalidDocumentClassException::class);
        $this->expectExceptionMessage('Something failed.');

        $middleware = $this->getMiddleware();

        $middleware->handle(
            $this->getRequest(),
            static function (): void {
                throw new InvalidDocumentClassException('Something failed.');
            }
        );
    }

    /**
     * Test handling of a response which is not instance of Response or ResponseInterface
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandleResponseWhenItsNotKnownType(): void
    {
        $httpLogger = new HttpLoggerStub();
        $middleware = $this->getMiddleware($httpLogger);

        $middleware->handle(
            $this->getRequest(),
            static function (): string {
                return '{"json": "ok"}';
            }
        );

        self::assertNull($httpLogger->getResponse());
    }

    /**
     * Test if handle can intercept response which is already in PSR7 format
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandleWhenResponseFromControllerIsAlreadyPsr7(): void
    {
        $middleware = $this->getMiddleware();

        $response = $middleware->handle(
            $this->getRequest(),
            static function (): ResponseInterface {
                return new TextResponse('OK');
            }
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('OK', (string)$response->getBody());
    }

    /**
     * Test if exception thrown by http logger service is logged using logger interface
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHttpLoggerExceptionsAreLoggedByLoggerInterface(): void
    {
        $httpLogger = new HttpLoggerExceptionStub(); // this stub specifically throws an exception
        $logHandler = new LogHandlerStub();
        $middleware = $this->getMiddleware($httpLogger, $logHandler);

        $middleware->handle(
            $this->getRequest(),
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertCount(1, $logHandler->getLogs());
        $log = $logHandler->getLogs()[0];
        self::assertArrayHasKey('message', $log);
        self::assertSame('Exception caught: This is a test exception', $log['message']);
    }

    /**
     * Test to assert that an exception is caught and the process
     * continues to generate psr7 request/response
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testProcessingContinuesWhenExceptionIsThrownInOriginalProcess(): void
    {
        $httpLogger = new HttpLoggerStub();
        $middleware = $this->getMiddleware($httpLogger);

        try {
            $middleware->handle(
                $this->getRequest(),
                static function (): void {
                    throw new InvalidDocumentClassException('Something failed.');
                }
            );
        } catch (InvalidDocumentClassException $exception) {
            // catching exception so we can assert the the process continues to send data to http logger
        }

        self::assertInstanceOf(ServerRequestInterface::class, $httpLogger->getRequest());
        self::assertNull($httpLogger->getResponse());
        self::assertInstanceOf(DateTime::class, $httpLogger->getNow());
    }

    /**
     * Test if exceptions thrown when trying to create psr requests are logged
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testPsrRequestExceptionsAreLoggedByLoggerInterface(): void
    {
        $logHandler = new LogHandlerStub();
        $middleware = $this->getMiddleware(null, $logHandler);

        $middleware->handle(
            new Request(), // this will throw an exception while trying to create psr7 request as HOST is missing
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertCount(1, $logHandler->getLogs());
        $log = $logHandler->getLogs()[0];
        self::assertArrayHasKey('message', $log);
        self::assertSame('Exception caught: The source URI string appears to be malformed', $log['message']);
    }

    /**
     * Test if exceptions thrown when trying to create psr response are logged
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testPsrResponseExceptionsAreLoggedByLoggerInterface(): void
    {
        $logHandler = new LogHandlerStub();
        $middleware = $this->getMiddleware(null, $logHandler);

        $middleware->handle(
            $this->getRequest(),
            static function (): Response {
                // this should throw an invalid status code exception when converting to psr 7
                return new ResponseStub(1);
            }
        );

        self::assertCount(1, $logHandler->getLogs());
        $log = $logHandler->getLogs()[0];
        self::assertArrayHasKey('message', $log);
        self::assertSame(
            'Exception caught: Invalid status code "1"; must be an integer between 100 and 599, inclusive',
            $log['message']
        );
    }

    /**
     * Test if middleware passes valid data to http logger
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testValidDataIsPassedToHttpLogger(): void
    {
        $httpLogger = new HttpLoggerStub();
        $middleware = $this->getMiddleware($httpLogger);

        $middleware->handle(
            $this->getRequest(),
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertSame('127.0.0.1', $httpLogger->getIpAddress());
        self::assertInstanceOf(RequestInterface::class, $httpLogger->getRequest());
        self::assertSame('loyaltycorp.com.au', $httpLogger->getRequest()->getUri()->getHost());
        self::assertInstanceOf(ResponseInterface::class, $httpLogger->getResponse());
        self::assertSame('OK', (string)$httpLogger->getResponse()->getBody());
    }

    /**
     * Test if middleware logs the forwarding proxy address if it is available.
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testProxyIpPassedToHttpLogger(): void
    {
        $httpLogger = new HttpLoggerStub();
        $middleware = $this->getMiddleware($httpLogger);

        $middleware->handle(
            $this->getRequest(['HTTP_X-Forwarded-For' => '127.2.3.4']),
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertInstanceOf(RequestInterface::class, $httpLogger->getRequest());
        self::assertInstanceOf(ResponseInterface::class, $httpLogger->getResponse());
        self::assertSame('127.2.3.4', $httpLogger->getIpAddress());
        self::assertSame('loyaltycorp.com.au', $httpLogger->getRequest()->getUri()->getHost());
        self::assertSame('OK', (string)$httpLogger->getResponse()->getBody());
    }

    /**
     * Get instance of middleware
     *
     * @param \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface|null $httpLogger
     * @param \Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Monolog\Handler\LogHandlerStub|null $logHandlerStub
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware
     */
    private function getMiddleware(
        ?HttpLoggerInterface $httpLogger = null,
        ?LogHandlerStub $logHandlerStub = null
    ): AuditMiddleware {
        return new AuditMiddleware(
            $httpLogger ?? new HttpLoggerStub(),
            new Logger(null, $logHandlerStub ?? new LogHandlerStub()),
            new Psr7Factory()
        );
    }

    /**
     * Get symfony request
     *
     * @param string[] $headers Optional list of additional headers
     *
     * @return \Illuminate\Http\Request
     */
    private function getRequest(array $headers = []): Request
    {
        $headers = \array_merge(['HTTP_HOST' => 'loyaltycorp.com.au', 'REMOTE_ADDR' => '127.0.0.1'], $headers);
        return new Request(
            ['query' => 'value'],
            ['request' => 'value'],
            [],
            [],
            [],
            $headers,
            'Content'
        );
    }
}

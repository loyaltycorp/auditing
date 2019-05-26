<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares;

use Illuminate\Http\Request;
use LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services\HttpLoggerStub;
use Tests\LoyaltyCorp\Auditing\TestCase;
use Zend\Diactoros\Response\TextResponse;

/**
 * @covers \LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware
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
        $middleware = $this->initiate();

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
     * returning null as response content
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testHandleHandlesExceptions(): void
    {
        $middleware = $this->initiate();
        $response = $middleware->handle(
            $this->getRequest(),
            static function (): void {
                throw new InvalidDocumentClassException('Something failed.');
            }
        );

        self::assertNull($response);
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
        $middleware = $this->initiate();

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
     * Test if middleware passes valid data to http logger
     *
     * @return void
     *
     * @throws \EoneoPay\Utils\Exceptions\InvalidDateTimeStringException
     */
    public function testValidDataIsPassedToHttpLogger(): void
    {
        $httpLogger = new HttpLoggerStub();
        $middleware = $this->initiate($httpLogger);

        $middleware->handle(
            $this->getRequest(),
            static function (): Response {
                return new Response('OK');
            }
        );

        self::assertSame('127.0.0.1', $httpLogger->getIpAddress());
        self::assertSame('loyaltycorp.com.au', $httpLogger->getRequest()->getUri()->getHost());
        self::assertInstanceOf(ResponseInterface::class, $httpLogger->getResponse());
        self::assertSame('OK', (string)$httpLogger->getResponse()->getBody());
    }

    /**
     * Get symfony request
     *
     * @return \Illuminate\Http\Request
     */
    private function getRequest(): Request
    {
        return new Request(
            ['query' => 'value'],
            ['request' => 'value'],
            [],
            [],
            [],
            ['HTTP_HOST' => 'loyaltycorp.com.au', 'REMOTE_ADDR' => '127.0.0.1'],
            'Content'
        );
    }

    /**
     * Get instance of middleware
     *
     * @param \LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface|null $httpLogger
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware
     */
    private function initiate(?HttpLoggerInterface $httpLogger = null): AuditMiddleware
    {
        return new AuditMiddleware(
            $httpLogger ?? new HttpLoggerStub(),
            new Psr7Factory()
        );
    }
}

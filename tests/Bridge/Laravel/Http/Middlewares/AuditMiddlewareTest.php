<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares;

use Illuminate\Http\Request;
use LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
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
            ['HTTP_HOST' => 'loyaltycorp.com.au'],
            'Content'
        );
    }

    /**
     * Get instance of middleware
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Http\Middlewares\AuditMiddleware
     */
    private function initiate(): AuditMiddleware
    {
        return new AuditMiddleware(
            new Psr7Factory()
        );
    }
}

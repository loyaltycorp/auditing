<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services\Factories;

use LoyaltyCorp\Auditing\Services\Factories\Psr7Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\Factories\Psr7Factory
 */
class Psr7FactoryTest extends TestCase
{
    /**
     * Test calling PstHttpFactory from createRequest creates a PSR7 request
     *
     * @return void
     */
    public function testCreateRequest(): void
    {
        $symfonyRequest = new Request(
            [],
            [],
            [],
            [],
            [],
            ['HTTP_HOST' => 'loyaltycorp.com.au'],
            'Content'
        );
        $factory = $this->getFactory();

        $psr7Request = $factory->createRequest($symfonyRequest);

        self::assertSame('Content', $psr7Request->getBody()->getContents());
        self::assertSame('loyaltycorp.com.au', $psr7Request->getUri()->getHost());
    }

    /**
     * Test calling PsrHttpFactory from createResponse creates a psr7 response
     *
     * @return void
     */
    public function testCreateResponse(): void
    {
        $symfonyResponse = new Response(
            '{}',
            200,
            ['Content-Type' => 'application/json']
        );

        $factory = $this->getFactory();
        $psr7Response = $factory->createResponse($symfonyResponse);

        $stream = $psr7Response->getBody();
        $stream->rewind(); // go to starting position on steam

        self::assertSame('{}', $stream->getContents());
    }

    /**
     * Get psr factory instance
     *
     * @return \LoyaltyCorp\Auditing\Services\Factories\Psr7Factory
     */
    private function getFactory(): Psr7Factory
    {
        return new Psr7Factory();
    }
}

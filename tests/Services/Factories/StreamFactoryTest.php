<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Services\Factories;

use GuzzleHttp\Psr7\BufferStream;
use LoyaltyCorp\Auditing\Services\Factories\StreamFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Services\Factories\StreamFactory
 */
class StreamFactoryTest extends TestCase
{
    /**
     * Test that create stream from file will return instance of BufferedStream.
     *
     * @return void
     */
    public function testCreateStreamFromFile(): void
    {
        $stream = $this->getFactory()->createStreamFromFile('', '');

        self::assertInstanceOf(BufferStream::class, $stream);
    }

    /**
     * Get stream factory.
     *
     * @return \Psr\Http\Message\StreamFactoryInterface
     */
    private function getFactory(): StreamFactoryInterface
    {
        return new StreamFactory();
    }
}

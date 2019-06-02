<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services\Factories;

use GuzzleHttp\Psr7\BufferStream;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\StreamFactory as ZendStreamFactory;

final class StreamFactory extends ZendStreamFactory
{
    /**
     * Overriding Zend\Diactoros\StreamFactory::createStreamFromFile() to return buffered stream instead of creating
     * stream from file for this package.
     *
     * @param string $file
     * @param string $mode
     *
     * @return \Psr\Http\Message\StreamInterface
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) Inherited from Zend StreamFactory
     */
    public function createStreamFromFile(string $file, string $mode = 'r'): StreamInterface
    {
        return new BufferStream();
    }
}

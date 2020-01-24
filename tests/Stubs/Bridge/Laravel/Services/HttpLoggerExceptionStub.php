<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel\Services;

use DateTime;
use LoyaltyCorp\Auditing\Bridge\Laravel\Services\Interfaces\HttpLoggerInterface;
use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use LoyaltyCorp\Multitenancy\Database\Entities\Provider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @coversNothing
 */
class HttpLoggerExceptionStub implements HttpLoggerInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function record(
        ?Provider $provider,
        string $ipAddress,
        DateTime $now,
        RequestInterface $request,
        ?ResponseInterface $response
    ): void {
        throw new InvalidDocumentClassException('This is a test exception');
    }
}

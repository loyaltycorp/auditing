<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing;

use Aws\CommandInterface;
use Aws\Result;
use GuzzleHttp\Promise;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use PHPUnit\Framework\TestCase as BaseTestCae;
use Psr\Http\Message\RequestInterface;

/**
 * @coversNothing
 */
class TestCase extends BaseTestCae
{
    /**
     * Get connection.
     *
     * @param \Closure $handler
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface
     */
    protected function getConnection(?\Closure $handler = null): ConnectionInterface
    {
        $conn = new Connection(
            'key',
            'secret',
            'ap-southeast-2',
            'http://localhost:8000',
            'latest',
            $handler
        );

        return $conn;
    }

    /**
     * Get mock handler for AWS connection.
     *
     * @param mixed[]|null $result
     *
     * @return \Closure
     */
    protected function getMockHandler(?array $result = null): \Closure
    {
        $myHandler = function (CommandInterface $cmd, RequestInterface $request) use ($result) {
            $result = new Result($result ?? []);
            return Promise\promise_for($result);
        };

        return $myHandler;
    }
}

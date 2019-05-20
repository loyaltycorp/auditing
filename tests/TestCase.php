<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing;

use Aws\CommandInterface;
use Aws\Result;
use GuzzleHttp\Promise;
use Illuminate\Console\Command;
use Laravel\Lumen\Application;
use LoyaltyCorp\Auditing\Client\Connection;
use LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface;
use PHPUnit\Framework\TestCase as BaseTestCae;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @coversNothing
 */
class TestCase extends BaseTestCae
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication(): Application
    {
        /** @noinspection UsingInclusionReturnValueInspection This is how lumen is bootstrapped */
        return require \dirname(__DIR__) . '/tests/bootstrap/app.php';
    }

    /**
     * Create command instance
     *
     * @param string $commandClass Command class
     * @param \Symfony\Component\Console\Output\OutputInterface $output The interface to output the result to
     *
     * @return \LoyaltyCorp\Auditing\Bridge\Laravel\Console\Commands\CreateSchemaCommand
     *
     * @throws \ReflectionException If class being reflected does not exist
     */
    protected function createCommandInstance(string $commandClass, OutputInterface $output): Command
    {
        // Use reflection to access input and output properties as these are protected
        // and derived from the application/console input/output
        $class = new ReflectionClass($commandClass);
        $inputProperty = $class->getProperty('input');
        $outputProperty = $class->getProperty('output');

        // Set properties to public
        $inputProperty->setAccessible(true);
        $outputProperty->setAccessible(true);

        // Create instance
        $instance = new $commandClass();

        // Set input/output property values
        $outputProperty->setValue($instance , $output);

        return $instance;
    }

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

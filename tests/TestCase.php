<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing;

use Aws\CommandInterface;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\MockHandler;
use Aws\Result;
use EoneoPay\Externals\Environment\Env;
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
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects) Centralised logic for all tests
 * @SuppressWarnings(PHPMD.NumberOfChildren) All tests extend this class
 */
class TestCase extends BaseTestCae
{
    /**
     * Env instance
     *
     * @var \EoneoPay\Externals\Environment\Env
     */
    private $env;

    /**
     * Values which have been modified via setEnv()
     *
     * @var mixed[]
     */
    private $environmentValues = [];

    /**
     * DynamoDb Marshaler instance.
     *
     * @var \Aws\DynamoDb\Marshaler|null
     */
    private $marshaler;

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
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        parent::tearDown();

        // Reset environment
        $this->resetEnv();
    }

    /**
     * Assert that the provided string is a v4 uuid.
     *
     * @param string $uuid4
     *
     * @return void
     */
    protected function assertUuid4(string $uuid4): void
    {
        $matches = [];
        $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        \preg_match($regex, $uuid4, $matches);

        self::assertTrue(\count($matches) > 0);
    }

    /**
     * Create command instance
     *
     * @param string $commandClass Command class
     * @param \Symfony\Component\Console\Output\OutputInterface $output The interface to output the result to
     *
     * @return \Illuminate\Console\Command
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
        $outputProperty->setValue($instance, $output);

        return $instance;
    }

    /**
     * Create mock handler with response.
     *
     * @param mixed[]|null $result
     * @param bool|null $exception
     *
     * @return \Aws\MockHandler
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable) The request variable is unused intentionally
     */
    protected function createMockHandler(?array $result = null, ?bool $exception = null): MockHandler
    {
        $handler = new MockHandler();
        $result = $result ?? [];

        if ($exception === true) {
            $handler->append(function (CommandInterface $cmd, RequestInterface $req) use ($result) {
                return new DynamoDbException(
                    $result['message'] ?? 'Mock exception.',
                    $cmd,
                    $result
                );
            });

            return $handler;
        }

        $handler->append(new Result($result));

        return $handler;
    }

    /**
     * Get connection.
     *
     * @param \Aws\MockHandler $handler
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\Client\ConnectionInterface
     */
    protected function getConnection(?MockHandler $handler = null): ConnectionInterface
    {
        $conn = new Connection(
            'key',
            'secret',
            'ap-southeast-2',
            'http://localhost:8000',
            'latest',
            ['handler' => $handler ?? $this->createMockHandler()]
        );

        return $conn;
    }

    /**
     * Get env instance
     *
     * @return \EoneoPay\Externals\Environment\Env
     */
    protected function getEnv(): Env
    {
        return $this->env ?? $this->env = new Env();
    }

    /**
     * Get DynamoDb marshaler.
     *
     * @return \Aws\DynamoDb\Marshaler
     */
    protected function getMarshaler(): Marshaler
    {
        if (($this->marshaler instanceof Marshaler) === false) {
            $this->marshaler = new Marshaler();
        }

        return $this->marshaler;
    }

    /**
     * Set env value
     *
     * @param string $key The key to set
     * @param mixed $value The value to assign to the key
     *
     * @return bool
     */
    protected function setEnv(string $key, $value): bool
    {
        // Capture key so it can be unset via `putenv` on teardown
        $this->environmentValues[] = $key;

        return $this->getEnv()->set($key, $value);
    }

    /**
     * Reset modified env values
     *
     * @return void
     */
    private function resetEnv(): void
    {
        foreach ($this->environmentValues as $key) {
            \putenv($key);
        }

        // Reset values
        $this->environmentValues = [];
    }
}

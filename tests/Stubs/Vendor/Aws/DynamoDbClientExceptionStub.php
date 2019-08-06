<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Aws;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Result;

/**
 * @coversNothing
 */
class DynamoDbClientExceptionStub extends DynamoDbClient
{
    /**
     * @var \Aws\DynamoDb\Exception\DynamoDbException|null
     */
    private $exception;

    /**
     * DynamoDbClientExceptionStub constructor.
     *
     * @param \Aws\DynamoDb\Exception\DynamoDbException $exception
     */
    public function __construct(?DynamoDbException $exception = null)
    {
        $this->exception = $exception;
    }

    /**
     * Overriding parent deleteTable method.
     *
     * @param mixed[] $args
     *
     * @return \Aws\Result
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) argument required to override parent.
     */
    public function deleteTable(array $args = []): Result
    {
        if ($this->exception === null) {
            return new Result();
        }

        throw $this->exception;
    }

    /**
     * Overriding parent deleteTable method.
     *
     * @param mixed[] $args
     *
     * @return \Aws\Result
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) argument required to override parent.
     */
    public function createTable(array $args = []): Result
    {
        if ($this->exception === null) {
            return new Result();
        }

        throw $this->exception;
    }
}

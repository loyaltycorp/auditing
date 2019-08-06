<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Aws;

use Aws\Command;
use Aws\DynamoDb\Exception\DynamoDbException;
use GuzzleHttp\Psr7\Response;

/**
 * @coversNothing
 */
class DynamoDbDeleteTableExceptionStub extends DynamoDbException
{
    /**
     * DynamoDbDeleteTableExceptionStub constructor.
     */
    public function __construct()
    {
        parent::__construct(
            '',
            new Command('DeleteTable'),
            [
                'code' => 'ResourceNotFoundException',
                'response' => new Response(400)
            ]
        );
    }
}

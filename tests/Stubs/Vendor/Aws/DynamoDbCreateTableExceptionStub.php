<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Aws;

use Aws\Command;
use Aws\DynamoDb\Exception\DynamoDbException;
use GuzzleHttp\Psr7\Response;

/**
 * @coversNothing
 */
class DynamoDbCreateTableExceptionStub extends DynamoDbException
{
    /**
     * DynamoDbCreateTableExceptionStub constructor.
     */
    public function __construct()
    {
        parent::__construct(
            '',
            new Command('CreateTable'),
            [
                'code' => 'ResourceInUseException',
                'response' => new Response(400)
            ]
        );
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Exceptions;

use LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Exceptions\InvalidDocumentClassException
 */
class InvalidDocumentClassExceptionTest extends TestCase
{
    /**
     * Test all exceptions have a code
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $message = 'Test message.';
        $exception = new InvalidDocumentClassException($message, 500);

        self::assertSame(500, $exception->getCode());
        self::assertSame($message, $exception->getMessage());
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Exceptions;

use LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Exceptions\DocumentCreateFailedException
 */
class DocumentCreateFailedExceptionTest extends TestCase
{
    /**
     * Test all exceptions have a code
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $message = 'Failed to create document.';
        $exception = new DocumentCreateFailedException($message, 500);

        self::assertSame(500, $exception->getCode());
        self::assertSame($message, $exception->getMessage());
    }
}

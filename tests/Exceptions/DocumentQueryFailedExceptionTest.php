<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Exceptions;

use LoyaltyCorp\Auditing\Exceptions\DocumentQueryFailedException;
use Tests\LoyaltyCorp\Auditing\TestCase;

/**
 * @covers \LoyaltyCorp\Auditing\Exceptions\DocumentQueryFailedException
 */
class DocumentQueryFailedExceptionTest extends TestCase
{
    /**
     * Test all exceptions have a code
     *
     * @return void
     */
    public function testExceptionCodes(): void
    {
        $message = 'Failed to query document.';
        $exception = new DocumentQueryFailedException($message, 500);

        self::assertSame(500, $exception->getCode());
        self::assertSame($message, $exception->getMessage());
    }
}

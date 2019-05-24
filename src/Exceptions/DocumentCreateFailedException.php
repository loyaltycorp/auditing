<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Exceptions;

use RuntimeException;
use Throwable;

final class DocumentCreateFailedException extends RuntimeException
{
    /**
     * DocumentCreateFailedException constructor.
     *
     * @param string|null $message
     * @param int|null $code
     * @param \Throwable|null $previous
     */
    public function __construct(?string $message = null, ?int $code = 0, ?Throwable $previous = null)
    {
        $code = $code ?? 500;
        $message = $message ?? '';

        parent::__construct($message, $code, $previous);
    }
}

<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Symfony\Component\Console;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @coversNothing
 */
class BufferedOutputStub extends BufferedOutput
{
    /**
     * Confirm success.
     *
     * @var bool
     */
    private $confirmSuccess;

    /**
     * BufferedOutputStub constructor.
     *
     * @param int|null $verbosity
     * @param bool $decorated
     * @param \Symfony\Component\Console\Formatter\OutputFormatterInterface|null $formatter
     * @param bool|null $confirmSuccess
     */
    public function __construct(
        ?int $verbosity = null,
        ?bool $decorated = null,
        ?OutputFormatterInterface $formatter = null,
        ?bool $confirmSuccess = null
    ) {
        $decorated = $decorated ?? false;
        $verbosity = $verbosity ?? self::VERBOSITY_NORMAL;

        parent::__construct($verbosity, $decorated, $formatter);

        $this->confirmSuccess = $confirmSuccess ?? true;
    }

    /**
     * Confirm a question with the user.
     *
     * @param string $question
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter) The confirm method param is unused intentionally for stubbing
     */
    public function confirm(string $question): bool
    {
        return $this->confirmSuccess;
    }
}

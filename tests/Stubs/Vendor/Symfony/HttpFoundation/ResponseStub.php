<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Symfony\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;

/**
 * @coversNothing
 */
class ResponseStub extends Response
{
    /**
     * @var int
     */
    private $overrideStatusCode;

    /**
     * ResponseStub constructor.
     *
     * @param int $statusCode
     */
    public function __construct(?int $statusCode = null)
    {
        $this->overrideStatusCode = $statusCode ?? 200;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->overrideStatusCode;
    }
}

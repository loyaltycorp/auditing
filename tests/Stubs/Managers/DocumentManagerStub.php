<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Managers;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;

/**
 * @coversNothing
 */
class DocumentManagerStub implements DocumentManagerInterface
{
    /**
     * Result data.
     *
     * @var mixed[]
     */
    private $results;

    /**
     * Construct DocumentManager stub
     *
     * @param mixed[]|null $results Sample results
     */
    public function __construct(?array $results = null)
    {
        $this->results = $results ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function create(DataObjectInterface $dataObject): Result
    {
        return new Result([
            'test' => 'ok'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function list(string $documentClass, ?string $expression = null, ?array $attributeValues = null): array
    {
        return $this->results;
    }
}

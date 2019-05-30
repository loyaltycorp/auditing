<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Managers;

use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\ResponseInterface;
use LoyaltyCorp\Auditing\Response;

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
    public $results;

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
    public function create(DataObjectInterface $dataObject): ResponseInterface
    {
        $this->results = $dataObject->toArray();

        return new Response($this->results);
    }

    /**
     * {@inheritdoc}
     */
    public function list(string $documentClass, ?string $expression = null, ?array $attributeValues = null): array
    {
        return $this->results;
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $objectId, DataObjectInterface $dataObject): ResponseInterface
    {
        $this->results = $dataObject->toArray();

        return new Response($this->results);
    }
}

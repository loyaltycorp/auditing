<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Managers;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;

interface DocumentManagerInterface
{
    /**
     * Create document item to the database.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject Data transfer object
     *
     * @return \Aws\Result
     */
    public function create(DataObjectInterface $dataObject): Result;

    /**
     * List document items by give expression.
     *
     * @param string $documentClass
     * @param string|null $expression
     * @param mixed[]|null $attributeValues
     *
     * @return mixed[]
     */
    public function list(
        string $documentClass,
        ?string $expression = null,
        ?array $attributeValues = null
    ): array;

    /**
     * Update document item.
     *
     * @param string $objectId Document object id
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject Data transfer object
     *
     * @return \Aws\Result
     */
    public function update(string $objectId, DataObjectInterface $dataObject): Result;
}

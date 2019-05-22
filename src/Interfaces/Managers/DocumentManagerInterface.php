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
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject
     *
     * @return \Aws\Result
     */
    public function create(DataObjectInterface $dataObject): Result;

    /**
     * List document items by give expression.
     *
     * @param string $documentClass
     * @param string|null $expression
     * @param array|null $attributeValues
     *
     * @return \Aws\Result
     */
    public function list(
        string $documentClass,
        ?string $expression = null,
        ?array $attributeValues = null
    ): Result;
}

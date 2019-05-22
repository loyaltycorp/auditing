<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Managers;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;

interface DocumentManagerInterface
{
    /**
     * Put document item to the database.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject
     *
     * @return \Aws\Result
     */
    public function create(DataObjectInterface $dataObject): Result;
}

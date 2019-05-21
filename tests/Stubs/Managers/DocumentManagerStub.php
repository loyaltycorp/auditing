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
     * {@inheritdoc}
     */
    public function putItem(DataObjectInterface $dataObject): Result
    {
        return new Result([
            'test' => 'ok'
        ]);
    }
}

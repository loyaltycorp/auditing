<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;

/**
 * @coversNothing
 */
class LogWriterStub implements LogWriterInterface
{
    /**
     * @var \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface[]
     */
    public $writtenDtos = [];

    /**
     * {@inheritdoc}
     */
    public function write(DataObjectInterface $dataObject): Result
    {
        $this->writtenDtos[] = $dataObject;

        return new Result();
    }
}

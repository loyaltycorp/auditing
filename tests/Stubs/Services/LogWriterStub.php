<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Services;

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
    public function listByLineStatus(int $lineStatus): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function write(DataObjectInterface $dataObject): void
    {
        $this->writtenDtos[] = $dataObject;
    }
}

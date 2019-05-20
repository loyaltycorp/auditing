<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs;

use LoyaltyCorp\Auditing\DataTransferObject;

/**
 * @coversNothing
 */
class DtoStub extends DataTransferObject
{
    /**
     * {@inheritdoc}
     */
    public function getTableName(): string
    {
        return 'DtoStub';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'key' => 'value'
        ];
    }
}

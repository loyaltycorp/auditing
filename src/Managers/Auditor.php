<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Manager;

use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\AuditorInterface;
use LoyaltyCorp\Auditing\Manager;

final class Auditor extends Manager implements AuditorInterface
{
    /**
     * {@inheritdoc}
     */
    public function log(DataObjectInterface $dataObject): DataObjectInterface
    {
        $this->getDbClient()->putItem([
            self::TABLE_NAME_KEY => $dataObject->getTableName(),
            self::TABLE_ITEM_KEY => $this->getMarshaler()->marshalJson(
                \json_encode($dataObject->toArray()) ?: ''
            )
        ]);

        return $dataObject;
    }
}

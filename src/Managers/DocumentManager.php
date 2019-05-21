<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Managers;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Manager;

final class DocumentManager extends Manager implements DocumentManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function putItem(DataObjectInterface $dataObject): Result
    {
        $data = \array_merge($dataObject->toArray(), [
            'requestId' => $this->getGenerator()->uuid4()
        ]);

        $item = $this->getMarshaler()->marshalJson(\json_encode($data) ?: '');

        return $this->getDbClient()->putItem([
            self::TABLE_NAME_KEY => $dataObject->getTableName(),
            self::TABLE_ITEM_KEY => $item
        ]);
    }
}

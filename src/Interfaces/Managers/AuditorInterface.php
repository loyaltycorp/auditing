<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces\Managers;

use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;

interface AuditorInterface
{
    /**
     * Log data item.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface $dataObject
     *
     * @return \LoyaltyCorp\Auditing\Interfaces\DataObjectInterface
     */
    public function log(DataObjectInterface $dataObject): DataObjectInterface;
}

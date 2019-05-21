<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use Aws\Result;
use LoyaltyCorp\Auditing\Interfaces\DataObjectInterface;
use LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface;
use LoyaltyCorp\Auditing\Interfaces\Services\LogWriterInterface;

final class LogWriter implements LogWriterInterface
{
    /**
     * Document manager.
     *
     * @var \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface
     */
    private $docManager;

    /**
     * LogWriter constructor.
     *
     * @param \LoyaltyCorp\Auditing\Interfaces\Managers\DocumentManagerInterface $docManager
     */
    public function __construct(DocumentManagerInterface $docManager)
    {
        $this->docManager = $docManager;
    }

    /**
     * {@inheritdoc}
     */
    public function write(DataObjectInterface $dataObject): Result
    {
        // @todo: implement retry on exception
        return $this->docManager->putItem($dataObject);
    }
}

<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObjects\LogLine;
use LoyaltyCorp\Auditing\Documents\AuditLog;
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
    public function write(LogLine $dataObject): void
    {
        $this->docManager->create($dataObject);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function listByLineStatus(int $lineStatus): array
    {
        return $this->docManager->list(
            AuditLog::class,
            'lineStatus = :lineStatus',
            [':lineStatus' => $lineStatus]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $requestId, LogLine $dataObject): void
    {
        $this->docManager->update($requestId, $dataObject);
    }
}

<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\DataTransferObjects;

use LoyaltyCorp\Auditing\DataTransferObject;

class AuditLog extends DataTransferObject
{
    /**
     * Occurred at date.
     *
     * @var string
     */
    private $occurredAt;

    /**
     * Request id.
     *
     * @var string
     */
    private $requestId;

    /**
     * AuditLog constructor.
     *
     * @param string $requestId
     * @param string $occurredAt
     */
    public function __construct(string $requestId, string $occurredAt)
    {
        $this->requestId = $requestId;
        $this->occurredAt = $occurredAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName(): string
    {
        return 'AuditLog';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'occurredAt' => $this->occurredAt,
            'requestId' => $this->requestId
        ];
    }
}

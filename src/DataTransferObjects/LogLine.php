<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\DataTransferObjects;

use DateTime;
use EoneoPay\Utils\Interfaces\UtcDateTimeInterface;
use LoyaltyCorp\Auditing\DataTransferObject;

class LogLine extends DataTransferObject
{
    /**
     * Client ip
     *
     * @var string
     */
    private $clientIp;

    /**
     * Line status
     *
     * This field is for indicating if we've synced this line to Elastic search or not.
     *
     * @var int
     */
    private $lineStatus;

    /**
     * Occurred timestamp
     *
     * @var \DateTime
     */
    private $occurredAt;

    /**
     * Request data
     *
     * @var string
     */
    private $requestData;

    /**
     * Response data
     *
     * @var string
     */
    private $responseData;

    /**
     * LogLineDto constructor.
     *
     * @param string $clientIp Client ip
     * @param int $lineStatus Status
     * @param \DateTime $occurredAt Occurred timestamp
     * @param string $requestData Request data
     * @param string $responseData Response data
     */
    public function __construct(
        string $clientIp,
        int $lineStatus,
        DateTime $occurredAt,
        string $requestData,
        string $responseData

    ) {
        $this->clientIp = $clientIp;
        $this->lineStatus = $lineStatus;
        $this->occurredAt = $occurredAt;
        $this->requestData = $requestData;
        $this->responseData = $responseData;
    }

    /**
     * Get client ip.
     *
     * @return string
     */
    public function getClientIp(): string
    {
        return $this->clientIp;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getLineStatus(): int
    {
        return $this->lineStatus;
    }

    /**
     * Get occurred timestamp.
     *
     * @return \DateTime
     */
    public function getOccurredAt(): DateTime
    {
        return $this->occurredAt;
    }

    /**
     * Get request data.
     *
     * @return string
     */
    public function getRequestData(): string
    {
        return $this->requestData;
    }

    /**
     * Get response data.
     *
     * @return string
     */
    public function getResponseData(): string
    {
        return $this->responseData;
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
            'clientIp' => $this->clientIp,
            'lineStatus' => $this->lineStatus,
            'occurredAt' => $this->occurredAt->format(UtcDateTimeInterface::FORMAT_ZULU),
            'requestData' => $this->requestData,
            'responseData' => $this->responseData
        ];
    }
}

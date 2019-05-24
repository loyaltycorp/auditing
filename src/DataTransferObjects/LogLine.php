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
     * @var string|null
     */
    private $responseData;

    /**
     * Status
     * This field is for indicating if we've synced this line to Elastic search or not.
     *
     * @var int
     */
    private $status;

    /**
     * LogLineDto constructor.
     *
     * @param string $clientIp Client ip
     * @param \DateTime $occurredAt Occurred timestamp
     * @param string $requestData Request data
     * @param string $responseData Response data
     * @param int $status Status
     */
    public function __construct(
        string $clientIp,
        DateTime $occurredAt,
        string $requestData,
        ?string $responseData,
        int $status
    ) {
        $this->clientIp = $clientIp;
        $this->occurredAt = $occurredAt;
        $this->requestData = $requestData;
        $this->responseData = $responseData;
        $this->status = $status;
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
     * @return string|null
     */
    public function getResponseData(): ?string
    {
        return $this->responseData;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
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
            'occurredAt' => $this->occurredAt->format(UtcDateTimeInterface::FORMAT_ZULU),
            'requestData' => $this->requestData,
            'responseData' => $this->responseData,
            'status' => $this->status
        ];
    }
}

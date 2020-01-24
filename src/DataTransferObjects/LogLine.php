<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\DataTransferObjects;

use DateTime;
use EoneoPay\Utils\Interfaces\UtcDateTimeInterface;
use LoyaltyCorp\Auditing\DataTransferObject;
use LoyaltyCorp\Auditing\Interfaces\DataTransferObjects\LogLineInterface;

class LogLine extends DataTransferObject implements LogLineInterface
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
     * Provider id.
     *
     * @var string|null
     */
    private $providerId;

    /**
     * Request data
     *
     * @var string|null
     */
    private $requestData;

    /**
     * Response data
     *
     * @var string|null
     */
    private $responseData;

    /**
     * LogLineDto constructor.
     *
     * @param string $clientIp Client ip
     * @param int $lineStatus Status
     * @param \DateTime $occurredAt Occurred timestamp
     * @param string|null $providerId
     * @param string|null $requestData Request data
     * @param string|null $responseData Response data
     */
    public function __construct(
        string $clientIp,
        int $lineStatus,
        DateTime $occurredAt,
        ?string $providerId,
        ?string $requestData,
        ?string $responseData
    ) {
        $this->clientIp = $clientIp;
        $this->lineStatus = $lineStatus;
        $this->occurredAt = $occurredAt;
        $this->providerId = $providerId;
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
     * Get provider.
     *
     * @return string|null
     */
    public function getProviderId(): ?string
    {
        return $this->providerId;
    }

    /**
     * Get request data.
     *
     * @return string
     */
    public function getRequestData(): ?string
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
            'providerId' => $this->getProviderId(),
            'requestData' => $this->requestData,
            'responseData' => $this->responseData
        ];
    }
}

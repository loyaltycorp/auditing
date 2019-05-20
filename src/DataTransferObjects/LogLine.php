<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\DataTransferObjects;

use DateTime;
use LoyaltyCorp\Auditing\DataTransferObject;

class LogLine extends DataTransferObject
{
    /**
     * @var string
     */
    private $clientIp;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    /**
     * @var array|mixed[]
     */
    private $requestData;

    /**
     * @var array|mixed[]
     */
    private $responseData;

    /**
     * @var int
     */
    private $status;

    /**
     * LogLineDto constructor.
     *
     * @param string $clientIp Client ip
     * @param \DateTime $occurredAt Occurred timestamp
     * @param mixed[] $requestData Request data
     * @param mixed[] $responseData Response data
     * @param int $status Status
     */
    public function __construct(
        string $clientIp,
        DateTime $occurredAt,
        array $requestData,
        array $responseData,
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
     * @return mixed[]
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * Get response data.
     *
     * @return mixed[]
     */
    public function getResponseData(): array
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
        return 'LogLine';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'clientIp' => $this->clientIp,
            'occurredAt' => $this->occurredAt,
            'requestData' => $this->requestData,
            'responseData' => $this->responseData,
            'status' => $this->status
        ];
    }
}

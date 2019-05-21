<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services;

use LoyaltyCorp\Auditing\Interfaces\Services\UuidGeneratorInterface;
use Ramsey\Uuid\UuidFactoryInterface;

class UuidGenerator implements UuidGeneratorInterface
{
    /**
     * Uuid factory.
     *
     * @var \Ramsey\Uuid\UuidFactoryInterface
     */
    private $uuidFactory;

    /**
     * UuidGenerator constructor.
     *
     * @param \Ramsey\Uuid\UuidFactoryInterface $uuidFactory
     */
    public function __construct(UuidFactoryInterface $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function uuid4(): string
    {
        return $this->uuidFactory->uuid4()->toString();
    }
}

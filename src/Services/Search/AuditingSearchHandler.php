<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Services\Search;

use LoyaltyCorp\Search\Interfaces\SearchHandlerInterface;

class AuditingSearchHandler implements SearchHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getMappings(): array
    {
        return [
            'doc' => [
                'dynamic' => 'strict',
                'properties' => [
                    'clientIp' => ['type' => 'keyword'],
                    'lineStatus' => ['type' => 'integer'],
                    'occurredAt' => ['type' => 'date'],
                    'providerId' => ['type' => 'keyword'],
                    'requestData' => ['type' => 'text'],
                    'responseData' => ['type' => 'text'],
                    'requestId' => ['type' => 'keyword']
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getSettings(): array
    {
        return [
            'number_of_replicas' => 1,
            'number_of_shards' => 1
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexName(): string
    {
        return 'http-requests';
    }
}

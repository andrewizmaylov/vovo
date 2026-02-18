<?php

declare(strict_types=1);

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class PaginatedResponse extends JsonResponse
{
    public function __construct(
        Collection $data,
        int $page,
        int $total,
        int $perPage,
        string $basePath = '/api/products',
    ) {
        $lastPage = (int) max(1, ceil($total / $perPage));

        $payload = [
            'data' => $data,
            'meta' => [
                'current_page' => $page,
                'from' => $total > 0 ? ($page - 1) * $perPage + 1 : null,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'to' => $total > 0 ? min($page * $perPage, $total) : null,
                'total' => $total,
            ],
            'links' => [
                'first' => $basePath . '?page=1',
                'last' => $basePath . '?page=' . $lastPage,
                'prev' => $page > 1 ? $basePath . '?page=' . ($page - 1) : null,
                'next' => $page < $lastPage ? $basePath . '?page=' . ($page + 1) : null,
            ],
        ];

        parent::__construct($payload);
    }
}

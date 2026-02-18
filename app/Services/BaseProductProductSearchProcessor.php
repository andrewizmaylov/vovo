<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Responses\PaginatedResponse;
use App\Services\ProductProcessors\Contracts\ProductSearchProcessorInterface;

class BaseProductProductSearchProcessor implements ProductSearchProcessorInterface
{

    public function handle(array $params): PaginatedResponse
    {
        $perPage = (int) ($params['per_page'] ?? 40);
        $perPage = min(max(1, $perPage), 100);
        $page = max(1, (int) ($params['page'] ?? 1));

        $query = Product::query()
            ->when(isset($params['name']), function ($q) use ($params) {
                $q->where('name', 'like', $params['name'] . '%');
            })
            ->when(isset($params['price_from']) || isset($params['price_to']), function ($q) use ($params) {
                $q->when($params['price_from'], fn ($q) => $q->where('price', '>=', $params['price_from']))
                    ->when($params['price_to'], fn ($q) => $q->where('price', '<=', $params['price_to']));
            })
            ->when(isset($params['in_stock']), function ($q) use ($params) {
                $q->where('in_stock', filter_var($params['in_stock'], FILTER_VALIDATE_BOOLEAN));
            })
            ->when(isset($params['category_id']), fn ($q) => $q->where('category_id', $params['category_id']))
            ->when(isset($params['rating_from']), fn ($q) => $q->where('rating', '>=', $params['rating_from']));

        $sort = $params['sort'] ?? 'newest';
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            default => $query->orderByDesc('created_at'),
        };

        $total = $query->count();

        $data = $query
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return new PaginatedResponse(
            $data,
            $page,
            $total,
            $perPage
        );
    }
}

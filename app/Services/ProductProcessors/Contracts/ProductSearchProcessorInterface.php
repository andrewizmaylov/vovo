<?php

namespace App\Services\ProductProcessors\Contracts;

use App\Responses\PaginatedResponse;

interface ProductSearchProcessorInterface
{
    public function handle(array $params): PaginatedResponse;
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetProductRequest;
use App\Responses\PaginatedResponse;
use App\Services\BaseProductProductSearchProcessor;

class GetProductsController extends Controller
{
    public function __construct(
        public BaseProductProductSearchProcessor $processor,
    )
    {
    }

    public function __invoke(GetProductRequest $request): PaginatedResponse
    {
        $validated = $request->validated();

        return $this->processor->handle($validated);
    }
}

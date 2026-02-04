<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetProductRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'name' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric',
            'in_stock' => 'nullable|in:1,0,true,false',
            'rating_from' => 'nullable|numeric',
            'sort' => 'nullable|string|in:price_asc,price_desc,rating_desc,newest',
        ];
    }
}

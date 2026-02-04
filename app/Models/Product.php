<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Product",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Product Name"),
        new OA\Property(property: "price", type: "number", format: "decimal", example: 99.99),
        new OA\Property(property: "category_id", type: "integer", example: 1),
        new OA\Property(property: "in_stock", type: "boolean", example: true),
        new OA\Property(property: "rating", type: "number", format: "float", example: 4.5),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-01-15T10:30:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-01-20T14:45:00Z")
    ],
    type: "object"
)]
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'in_stock' => 'boolean',
    ];
}

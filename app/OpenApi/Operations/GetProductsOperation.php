<?php

declare(strict_types=1);

namespace App\OpenApi\Operations;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/products',
    summary: 'Get products list with filtering and pagination',
    tags: ['Products'],
    parameters: [
        new OA\Parameter(
            name: "page",
            description: "Page number",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "integer", default: 1)
        ),
        new OA\Parameter(
            name: "per_page",
            description: "Items per page",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "integer", default: 40, maximum: 100)
        ),
        new OA\Parameter(
            name: "sort",
            description: "Sorting field and direction",
            in: "query",
            required: false,
            schema: new OA\Schema(
                type: "string",
                default: "newest",
                enum: ["price_asc", "price_desc", "rating_desc", "newest"]
            )
        ),
        new OA\Parameter(
            name: "name",
            description: "Search in product names (partial match)",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "string", maxLength: 255)
        ),
        new OA\Parameter(
            name: "price_from",
            description: "Minimum price filter",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "number", format: "float", minimum: 0, example: 10.50)
        ),
        new OA\Parameter(
            name: "price_to",
            description: "Maximum price filter",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "number", format: "float", minimum: 0, example: 1000.00)
        ),
        new OA\Parameter(
            name: "category_id",
            description: "Filter by category ID",
            in: "query",
            required: false,
            schema: new OA\Schema(
                description: "Available category IDs can be retrieved from /api/categories endpoint",
                type: "integer",
                example: 1
            )
        ),
        new OA\Parameter(
            name: "in_stock",
            description: "Filter by stock availability",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "boolean", enum: [true, false])
        ),
        new OA\Parameter(
            name: "rating_from",
            description: "Minimum rating filter",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "number", format: "float", maximum: 5, minimum: 0, example: 4.0)
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Successful operation",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(ref: "#/components/schemas/Product")
                    ),
                    new OA\Property(
                        property: "meta",
                        properties: [
                            new OA\Property(property: "current_page", type: "integer", example: 1),
                            new OA\Property(property: "from", type: "integer", example: 1),
                            new OA\Property(property: "last_page", type: "integer", example: 5),
                            new OA\Property(property: "per_page", type: "integer", example: 15),
                            new OA\Property(property: "to", type: "integer", example: 15),
                            new OA\Property(property: "total", type: "integer", example: 72)
                        ],
                        type: "object"
                    ),
                    new OA\Property(
                        property: "links",
                        properties: [
                            new OA\Property(property: "first", type: "string", example: "/api/products?page=1"),
                            new OA\Property(property: "last", type: "string", example: "/api/products?page=5"),
                            new OA\Property(property: "prev", type: "string", example: null, nullable: true),
                            new OA\Property(property: "next", type: "string", example: "/api/products?page=2", nullable: true)
                        ],
                        type: "object"
                    )
                ]
            )
        ),
        new OA\Response(
            response: 400,
            description: "Bad Request - Invalid parameters",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "The given data was invalid."),
                    new OA\Property(
                        property: "errors",
                        type: "object",
                        example: [
                            "price_from" => ["The price from must be a number."],
                            "per_page" => ["The per page must not be greater than 100."]
                        ],
                        additionalProperties: new OA\AdditionalProperties(
                            type: "array",
                            items: new OA\Items(type: "string")
                        )
                    )
                ]
            )
        ),
        new OA\Response(
            response: 401,
            description: "Unauthorized - Authentication required",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "Unauthenticated.")
                ]
            )
        ),
        new OA\Response(
            response: 403,
            description: "Forbidden - Insufficient permissions",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "This action is unauthorized.")
                ]
            )
        ),
        new OA\Response(
            response: 404,
            description: "Not Found - Category not found",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "Category not found.")
                ]
            )
        ),
        new OA\Response(
            response: 422,
            description: "Unprocessable Entity - Validation failed",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "The given data was invalid."),
                    new OA\Property(
                        property: "errors",
                        type: "object",
                        example: [
                            "category_id" => ["The selected category id is invalid."]
                        ],
                        additionalProperties: new OA\AdditionalProperties(
                            type: "array",
                            items: new OA\Items(type: "string")
                        )
                    )
                ]
            )
        ),
        new OA\Response(
            response: 429,
            description: "Too Many Requests - Rate limit exceeded",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "Too Many Attempts. Please try again later.")
                ]
            )
        ),
        new OA\Response(
            response: 500,
            description: "Internal Server Error",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: false),
                    new OA\Property(property: "message", type: "string", example: "Internal server error. Please try again later.")
                ]
            )
        )
    ]
)]
class GetProductsOperation
{
}

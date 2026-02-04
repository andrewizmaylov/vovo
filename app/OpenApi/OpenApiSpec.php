<?php

declare(strict_types=1);

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0',
    title: 'Vovo API',
    description: 'API documentation'
)]
#[OA\Server(url: '/api', description: 'API Server')]
class OpenApiSpec
{
}

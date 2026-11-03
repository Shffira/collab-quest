<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(title: 'To-Do List API', version: '1.0.0', description: 'API To-Do List Duo Developer')]
#[OA\Server(url: L5_SWAGGER_CONST_HOST)]
#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer', bearerFormat: 'Sanctum')]
class OpenApi
{
}
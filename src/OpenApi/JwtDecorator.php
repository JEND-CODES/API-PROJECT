<?php
// api/src/OpenApi/JwtDecorator.php
// https://api-platform.com/docs/core/jwt/
// https://stackoverflow.com/questions/66427570/configuring-api-platform-to-include-header-in-openapi-aka-swagger-documentatio

// Autre modèle de JWT Decorator :
// https://github.com/sjaulin/bilemo/blob/main/src/OpenApi/JwtDecorator.php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class JwtDecorator implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        // $openApi = ($this->decorated)($context);
        $openApi = $this->decorated->__invoke($context);

        $schemas = $openApi->getComponents()->getSchemas();
    
        $schemas['Token'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'pseudo',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'password',
                ],
            ],
        ]);

        $responses = [
            '200' => [
                'description' => 'Get JWT token',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Token',
                        ],
                    ],
                ]
            ]
        ];

        $content = new \ArrayObject([
            'application/json' => [
                'schema' => [
                    '$ref' => '#/components/schemas/Credentials',
                ],
            ],
        ]);

        $requestBody = new Model\RequestBody('Generate new JWT Token', $content);

        /* $requestBody = new Model\RequestBody(
            $description = 'Generate new JWT Token',
            $content = new \ArrayObject([
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/Credentials',
                    ],
                ],
            ]),
        ); */

        $post = new Model\Operation('postCredentialsItem', ['Token'], $responses, 'Get JWT token to login.', 'Enter your credentials to generate a JWT Token', new Model\ExternalDocumentation, [], $requestBody);

        /* $postOperation = new Model\Operation(
            'postCredentialsItem',
            $tags = [],
            $responses = [
                '200' => [
                    'description' => 'Get JWT token',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Token',
                            ],
                        ],
                    ],
                ],
            ],
            $summary = 'Get JWT token to login.',
            $description = '',
            $externalDocs = null,
            $parameters = [],
            $requestBody
        ); */


        $pathItem = new Model\PathItem('JWT Token', null, null, null, null, $post);

        /* $pathItem = new Model\PathItem(
            $ref = 'JWT Token',
            $summary = null,
            $get = null,
            $put = null,
            $post = $postOperation
        ); */

        $openApi->getPaths()->addPath('/api/login', $pathItem);
        
        return $openApi;
    }
}

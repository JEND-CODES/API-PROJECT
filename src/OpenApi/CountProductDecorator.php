<?php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

class CountProductDecorator implements OpenApiFactoryInterface
{
    /**
     * @var OpenApiFactoryInterface
     */
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $responses = [
            '200' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'total_number' => [
                                    'type' => 'integer',
                                    'example' => 7,
                                ]
                            ],
                        ],
                    ],
                ],
            ],
            '404' => [
                'description' => 'Result not found',
            ],
        ];

        $newOperation = new Operation('get', ['Product'], $responses, "Retrieves total number of products", "Query to retrieve total count of products");

        $pathItem = new PathItem(null, null, null, $newOperation);

        $openApi->getPaths()->addPath('/api/products/count', $pathItem);

        return $openApi;

    }

    
}

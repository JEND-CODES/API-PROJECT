<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProductRepository;

class CountProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/products/count", methods={"GET"})
     * @return Response
     */
    public function __invoke(): Response
    {
        $countProducts = $this->productRepository->count([]);

        return $this->json([
            'total_number' => $countProducts
        ]);

    }

}

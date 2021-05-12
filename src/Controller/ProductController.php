<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ProductRepository
     */
    private $productRepo;

    public function __construct(SerializerInterface $serializer, ProductRepository $productRepo)
    {
       $this->serializer = $serializer;
       $this->productRepo = $productRepo;
    }

    /**
     * @Route("/api/products/count", methods={"GET"})
     * @return Response
     */
    public function countAllProducts(): Response
    {
        $countProducts = $this->productRepo->count([]);

        return $this->json([
            'total_number' => $countProducts
        ]);

    }

    /**
     * @Route("/products/{id}", name="one_product", requirements={"id": "\d+"}, methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function oneProduct(int $id): Response
    {
        $product = $this->productRepo->find($id);

        if(!$product)
        {
            $data['@context'] = "/api/contexts/Error";
            $data['@type'] = "hydra:Error";
            $data['hydra:title'] = "An error occurred";
            $data['hydra:description'] = "Not found. The product $id does not exist";

            return $this->json($data, 404);
        }

        $oneProduct = $this->serializer->serialize($product, 'json', ['groups' => 'product_details:read']);

        $response = new Response($oneProduct, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;

    }

    /**
     * @Route("/products", name="all_products", methods={"GET"})
     * @return Response
     */
    public function allProducts(): Response
    {
        $products = $this->productRepo->findBy(array(), array('id' => 'DESC'));

        $allProducts = $this->serializer->serialize($products, 'json', ['groups' => 'products:read']);

        $response = new Response($allProducts, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;

    }

    /**
     * @Route("/bilemo/products", name="bilemo_products", methods={"GET"})
     * @return Response
     */
    public function bilemoProducts(): Response
    {
        return $this->render('bilemo/products.html.twig');
    }

    /**
     * @Route("/bilemo/products/{id}", name="bilemo_one_product", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function bilemoOneProduct(int $id): Response
    {
        $product = $this->productRepo->find($id);

        return $this->render('bilemo/oneProduct.html.twig', [
            'product' => $product
        ]);
    }

}

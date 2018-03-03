<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Product;


class ProductController extends Controller
{
  /**
   * @Route("/product", name="product")
   */
  public function index()
  {
    $entityManager = $this->getDoctrine()->getManager();

    $product = new Product();
    $product->setName('Test Product:'.rand());
    $product->setPrice(99.99);
    $product->setDescription('Test Description');

    $entityManager->persist($product);

    $entityManager->flush();

    return new Response('Saved new product with id '.$product->getId());
  }

  /**
   * @Route("/product/{id}", name="product_show")
   */
  public function showAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Product::class);

    $product = $repository->findOneBy(['name'=>'Test Product']);

    $products = $repository->findAll();

    if(!$product) {
      throw $this->createNotFoundException('No product found for id:'.$id);
    }

    return $this->render('product/product.html.twig', ['products'=>$products]);
  }

}

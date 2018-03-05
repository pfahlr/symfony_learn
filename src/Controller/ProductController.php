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
   * @Route("/product/set/{id}/{name}", name="product_set_name")
   */
  public function productSetName(Product $product, $name)
  {
    $entityManager = $this->getDoctrine()->getManager();

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found '
      );
    }

    $product->setName($name);
    $entityManager->flush();

    return $this->redirectToRoute('product_show',['id'=>$product->getId()]);
  }

  /**
   * @Route("/product/{id}", name="product_show" , requirements={"id"="\d+"}, defaults={"id"="1"})
   */
  public function showAction($id)
  {
    $repository = $this->getDoctrine()->getRepository(Product::class);

    $product = $repository->findOneBy(['id'=>$id]);


    if(!$product) {
      throw $this->createNotFoundException('No product found for id:'.$id);
    }

    return $this->render('product/product.html.twig', ['products'=>[$product]]);
  }

  /**
   * @Route("/product/all", name="product_show_all")
   */
  public function showAllAction()
  {
    $repository = $this->getDoctrine()->getRepository(Product::class);

    $products = $repository->findAll();

    return $this->render('product/product.html.twig', ['products'=>$products]);
  }

 /**
  * @Route("/product/depinj/{id}", name="product_by_dependency_injection")
  *
  */
  public function productByDependencyInjection(Product $product)
  {
    return $this->render('product/product.html.twig', ['products'=>[$product]]);
  }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\Category;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function index()
    {
      $product = $this->getDoctrine()->getManager()
                  ->getRepository(Product::class)->findAll();

                  
      return $this->render('product/index.html.twig', ['products' => $product]);
   
    }
   /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id)
    {
    	$product = $this->getDoctrine()->getManager()
    		->getRepository(Product::class)
    		->find($id);


      $categoryName = $product->getCategory();
      $user = $product->getUser();


    	if(!$product){
    		throw $this->createNotFoundException('No product found for'. $id);
    	}

    	return $this->render('product/show.html.twig', ['product' => $product, 'category'=> $categoryName, 'user'=> $user]);


    }


    /**
     * @Route("/product_new", name="product_new")
     */

    public function product_new()
    {
        return $this->render('product/create.html.twig');
    }



    /**
     * @Route("/product_create", name="create_product")
     */

    public function create(Request $request)
    {

      $category = new Category();
      $category->setName($request->get('category'));

      // get the current user and set it to an object.
      $user = $this->getUser();
     
      $entityManager = $this->getDoctrine()->getManager();

      $product = new Product();
      $product->setName($request->get('title'));
      $product->setPrice($request->get('price'));
      $product->setDescription($request->get('description'));

      $product->setCategory($category);

      $entityManager->persist($user); // you forgot to persist a new User
      $entityManager->persist($category);
      $entityManager->persist($product);
      $user->addProduct($product);
      $entityManager->flush(); // now try to flu

  
      return $this->redirectToRoute('products');

    }
     /**
     * @Route("/product/delete/{id}", name="delete_product")
     */

    public function delete(Request $request, $id)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $product = $this->getDoctrine()->getManager()
                      ->getRepository(Product::class)
                      ->find($id);

      $entityManager->remove($product);
      $entityManager->flush();

      return $this->redirectToRoute('products');
    }




}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */

    public function list()
    {
    	return new Response("this works");
    }

    /**
     * @Route("/blog/{slug}", name="blog_show")
     */

    public function show($slug)
    {
		return new Response("this works");
    }


}

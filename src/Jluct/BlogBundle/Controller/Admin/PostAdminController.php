<?php

namespace Jluct\BlogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PostAdminController extends Controller
{

    public function indexAction($page)
    {
        $em = $this->getDoctrine();
        $posts = $em->getRepository('JluctBlogBundle:Post')->getAllPostsByPages($page, 10, 0);

        return $this->render('JluctBlogBundle:Admin:index.html.twig', ['posts' => $posts]);
    }
    
}

<?php

namespace Jluct\BlogBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PostAdminController extends Controller
{

    public function indexAction($page)
    {
        $em = $this->getDoctrine();
        $posts = $em->getRepository('JluctBlogBundle:Post')->getPostsByPages($page);

        return $this->render('JluctBlogBundle:Admin:index.html.twig', ['posts' => $posts]);
    }
    
}

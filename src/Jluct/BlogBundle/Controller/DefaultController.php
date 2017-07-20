<?php

namespace Jluct\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($page = 1)
    {
        $em = $this->getDoctrine();
        $posts = $em->getRepository('JluctBlogBundle:Post')->getPostsByPages($page);

        return $this->render('JluctBlogBundle:Default:index.html.twig', ['posts' => $posts]);
    }

    public function postAction($id)
    {
        $em = $this->getDoctrine();
        $post = $em->getRepository('JluctBlogBundle:Post')->findOneBy([
            'id' => $id,
            'public' => true
        ]);

        return $this->render('JluctBlogBundle:Default:post.html.twig', ['post' => $post]);
    }

}

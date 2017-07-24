<?php

namespace Jluct\BlogBundle\Controller\Admin;

use Jluct\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PostAdminController extends Controller
{

    public function indexAction($page)
    {
        $em = $this->getDoctrine();
        $posts = $em->getRepository('JluctBlogBundle:Post')->getAllPostsByPages($page, 10, 0);

        return $this->render('JluctBlogBundle:Admin:index.html.twig', ['posts' => $posts]);
    }

    public function publicAction($id)
    {
        $doctrine = $this->getDoctrine();
        /**
         * @var Post $post
         */
        $post = $doctrine->getRepository('JluctBlogBundle:Post')->findOneBy([
            'id' => $id,
        ]);

        $post->setPublic(!$post->getPublic());

        $em = $doctrine->getManager();
        $em->persist($post);
        $em->flush();

        $this->addFlash(
            'success',
            'Your changes were saved!'
        );

        return $this->redirectToRoute('jluct_blog_admin_post_view');
    }
    
}

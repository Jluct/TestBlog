<?php

namespace Jluct\BlogBundle\Controller\Admin;

use Jluct\BlogBundle\Entity\Post;
use Jluct\BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;


class PostAdminController extends Controller
{

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine();
        $posts = $em->getRepository('JluctBlogBundle:Post')->getAllPostsByPages($page, 10, 0);

        return $this->render('JluctBlogBundle:Admin:index.html.twig', ['posts' => $posts]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
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

    public function createAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $file = $post->getImage();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                'image',
                $fileName
            );

            $post->setImage('/image/' . $fileName);

            if (!$form->isValid()) {
                $this->addFlash(
                    'danger',
                    'Data is not valid'
                );

                return $this->render('JluctBlogBundle:Admin:post.html.twig', [
                    'form' => $form->createView(),
                    'image' => $post->getImage()
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                'Post created!'
            );

            return $this->redirectToRoute('jluct_blog_admin_post_view');

        }
        
        return $this->render('JluctBlogBundle:Admin:post.html.twig', [
            'form' => $form->createView(),
            'image' => $post->getImage()
        ]);
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $image = $post->getImage();
        $post->setImage(new File($post->getImage(), false));
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            VarDumper::dump($post);
            $file = $post->getImage();
            if ($file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    'image',
                    $fileName
                );

                $post->setImage('/image/' . $fileName);
                if (file_exists($this->get('kernel')->getRootDir() . '/../web' . $image))
                    unlink($this->get('kernel')->getRootDir() . '/../web' . $image);

            } else {
                $post->setImage($image);
            }

            if (!$form->isValid()) {
                $this->addFlash(
                    'danger',
                    'Data is not valid'
                );
                return $this->render('JluctBlogBundle:Admin:post.html.twig', [
                    'form' => $form->createView(),
                    'image' => $post->getImage()
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'success',
                'Post created!'
            );

            return $this->redirectToRoute('jluct_blog_admin_post_view');
        }

        VarDumper::dump($request);
        VarDumper::dump($form);
        return $this->render('JluctBlogBundle:Admin:post.html.twig', [
            'form' => $form->createView(),
            'image' => $image
        ]);
    }
    
}

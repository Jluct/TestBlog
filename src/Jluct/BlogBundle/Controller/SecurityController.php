<?php
/**
 * Created by PhpStorm.
 * User: Inkognito
 * Date: 21.07.2017
 * Time: 13:41
 */

namespace Jluct\BlogBundle\Controller;

use Jluct\BlogBundle\Entity\User;
use Jluct\BlogBundle\Form\UserType;
use Jluct\BlogBundle\Services\User\CreateUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('JluctBlogBundle:Security:login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    public function checkAction()
    {
        return $this->render('JluctBlogBundle:Security:login.html.twig', []);

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     */
    public function registrationAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var CreateUser $registerService
             */
            $registerService = $this->get('jluct_blog.user.create');

            $data = $request->get('jluct_blogbundle_user');
            $data['active'] = true;
            $data['password'] = $data['password']['first'];
            
            $registerService->createUser($data);


            return $this->redirectToRoute('jluct_blog_homepage');
        }

        return $this->render('JluctBlogBundle:Security:registration.html.twig', ['form' => $form->createView()]);
    }
}
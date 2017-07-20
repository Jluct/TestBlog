<?php

namespace Jluct\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JluctBlogBundle:Default:index.html.twig');
    }
}

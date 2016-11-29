<?php

namespace Pjpl\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      return $this->render('PjplMaterialBundle:Default:index.html.twig');
    }
}

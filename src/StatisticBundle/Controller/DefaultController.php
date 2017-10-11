<?php

namespace StatisticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/sfsdfds")
     */
    public function indexAction()
    {
        return $this->render('StatisticBundle:Default:index.html.twig');
    }
}

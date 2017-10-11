<?php

namespace BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/sdfsdfsdfsfs")
     */
    public function indexAction()
    {
        return $this->render('BackupBundle:Default:index.html.twig');
    }
}

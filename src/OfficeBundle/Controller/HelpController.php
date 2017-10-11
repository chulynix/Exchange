<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/14/16
 * Time: 12:16 PM
 */

namespace OfficeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class HelpController
 * @package OfficeBundle\Controller
 */
class HelpController extends Controller
{
    /**
     * @return array
     *
     * @Route("/help", name="office_help")
     * @Template("OfficeBundle:Help:help.html.twig")
     */
    public function helpAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $helps = $em->getRepository('AdminFaqBundle:Faq')->findAll();

        return array(
            'helps' => $helps,
        );
    }
}

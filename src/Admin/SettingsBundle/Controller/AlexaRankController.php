<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 7/11/16
 * Time: 2:49 PM
 */

namespace Admin\SettingsBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AlexaRankController
 * @package Admin\SettingsBundle\Controller
 */
class AlexaRankController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/alexa-rank-settings/{id}", name="settings_alexa_rank")
     * @Template("AdminSettingsBundle:AlexaRank:alexa_rank.html.twig")
     */
    public function indexAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $settings = $em->getRepository('AdminSettingsBundle:AlexaRank')->find($id);
        } else {
            $settings = null;
        }

        $form = $this->createFormBuilder($settings)
            ->add('title', 'text')
            ->add('value', 'text')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->flush($data);

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('saved')
                );

                return $this->redirectToRoute('settings_alexa_rank');
            }
        }

        return array(
            'all_settings'  => $em->getRepository('AdminSettingsBundle:AlexaRank')->findAll(),
            'form'  => $form->createView(),
        );
    }
}

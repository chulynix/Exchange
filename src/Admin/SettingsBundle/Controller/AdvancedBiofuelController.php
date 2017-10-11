<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 7/11/16
 * Time: 10:39 AM
 */

namespace Admin\SettingsBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdvancedBiofuelController
 * @package Admin\SettingsBundle\Controller
 */
class AdvancedBiofuelController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/advanced-biofuel-settings/{id}", name="settings_advanced_biofuel")
     * @Template("AdminSettingsBundle:AdvancedBiofuel:advanced_biofuel.html.twig")
     */
    public function indexAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $settings = $em->getRepository('AdminSettingsBundle:AdvancedBiofuel')->find($id);
        } else {
            $settings = null;
        }

            $form = $this->createFormBuilder($settings)
                ->add('year', 'text')
                ->add('percent', 'text')
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

                return $this->redirectToRoute('settings_advanced_biofuel');
            }
        }

        return array(
            'all_settings'  => $em->getRepository('AdminSettingsBundle:AdvancedBiofuel')->findAll(),
            'form'  => $form->createView(),
        );
    }
}

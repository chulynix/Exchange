<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 7/11/16
 * Time: 11:25 AM
 */

namespace Admin\SettingsBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GlobalBiodieselController
 * @package Admin\SettingsBundle\Controller
 */
class GlobalBiodieselController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/global-biodiesel-settings/{id}", name="settings_global_biodiesel")
     * @Template("AdminSettingsBundle:GlobalBiodiesel:global_biodiesel.html.twig")
     */
    public function indexAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            $settings = $em->getRepository('AdminSettingsBundle:GlobalBiodiesel')->find($id);
        } else {
            $settings = null;
        }

        $form = $this->createFormBuilder($settings)
            ->add('text', 'text')
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

                return $this->redirectToRoute('settings_global_biodiesel');
            }
        }

        return array(
            'all_settings'  => $em->getRepository('AdminSettingsBundle:GlobalBiodiesel')->findAll(),
            'form'  => $form->createView(),
        );
    }
}

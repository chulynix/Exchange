<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/8/16
 * Time: 2:18 PM
 */

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Entity\Verification;
use UserBundle\Form\VerificationForm;

/**
 * Class VerificationController
 * @package UserBundle\Controller
 */
class VerificationController extends Controller
{
    /**
     * @return array
     *
     * @Route("/verification", name="office_verification")
     * @Template("UserBundle::verification.html.twig")
     */
    public function indexAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var $user User */
        $user = $this->getUser();

        if ($user->getVerification()) {
            $verification = $user->getVerification();
        } else {
            $verification = new Verification();
            $verification->setUser($user);
        }

        $form = $this->createForm(VerificationForm::class, $verification);

        $translator = $this->get('translator');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);

                $user->setVerificationStatus(1);

                $em->flush();

                $this->addFlash('success', $translator->trans('office.verification.verificution_send_success'));

                return $this->redirectToRoute('office_verification');
            } else {
                $this->addFlash('error', $translator->trans('office.verification.verificution_send_error'));
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}

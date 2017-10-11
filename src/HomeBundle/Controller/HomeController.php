<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class HomeController
 * @package HomeBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @return array
     *
     * @Route("/", name="home_index")
     * @Template("HomeBundle::index.html.twig")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/about", name="home_about")
     * @Template("HomeBundle::about.html.twig")
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/privacy", name="home_privacy")
     * @Template("HomeBundle::privacy.html.twig")
     */
    public function privacyAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/terms-and-conditions", name="home_terms_and_conditions")
     * @Template("HomeBundle::terms_and_conditions.html.twig")
     */
    public function termsAndConditionsAction()
    {
        return array();
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/contacts", name="home_contacts")
     * @Template("HomeBundle::contacts.html.twig")
     */
    public function contactsAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'home.contacts.name',
            ))
            ->add('email', EmailType::class, array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('message', TextareaType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'home.contacts.message',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($this->get('service_container')->getParameter('captcha')) {
                    $captcha = $_POST['g-recaptcha-response'];
                    $myCurl = curl_init();
                    curl_setopt_array($myCurl, array(
                        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => http_build_query(array(
                            'secret' => $this->get('service_container')->getParameter('captcha_secret'),
                            'response' => $captcha,
                        )),
                    ));
                    $response = curl_exec($myCurl);
                    curl_close($myCurl);
                    $result = json_decode($response);
                    if ($result->success) {
                        $this->sendMessage($form->get('name')->getData(), $form->get('email')->getData(), $form->get('message')->getData());

                        return $this->redirectToRoute('home_contacts');
                    } else {
                        $this->addFlash('error', 'Invalid Captcha!');
                    }
                } else {
                    $this->sendMessage($form->get('name')->getData(), $form->get('email')->getData(), $form->get('message')->getData());

                    return $this->redirectToRoute('home_contacts');
                }
            }
        }

        return array(
            'form' => $form->createView(),
            'captcha'   => $this->get('service_container')->getParameter('captcha'),
            'site_key' => $this->get('service_container')->getParameter('captcha_key'),
        );
    }

    protected function sendMessage($name, $email, $message)
    {
        $adminEmail = $this->get('service_container')->getParameter('admin_email');
        $message = \Swift_Message::newInstance()
            ->setSubject('Contacts form')
            ->setFrom($adminEmail)
            ->setTo($adminEmail)
            ->setBody(
                $this->renderView(
                    'HomeBundle::email.html.twig',
                    array(
                        'name'  => $name,
                        'email' => $email,
                        'text'  => $message,
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        $this->addFlash('success', $this->get('translator')->trans('home.contacts.mesage_sent_succces'));
    }
}

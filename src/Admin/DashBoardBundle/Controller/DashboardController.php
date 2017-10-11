<?php

namespace Admin\DashBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 * @package Admin\DashboardBundle\Controller
 */
class DashboardController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/dashboard", name="admin_dashboard")
     * @Template()
     */
    public function dashboardAction()
    {
        return $this->redirectToRoute('members_all_members');
    }
}

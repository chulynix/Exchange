<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 8/9/16
 * Time: 5:05 PM
 */

namespace Admin\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Admin\UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}

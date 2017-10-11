<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11.01.16
 * Time: 18:56
 */

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

/**
 * Class LoadUserData
 * @package UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 2; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setName('user'.$i);
            $user->setSurname('user'.$i);
            $user->setPlainPassword('user'.$i);
            $user->setEmail('user'.$i.'@user.com');
            $user->setEnabled(true);
            $user->addRole('ROLE_USER');
            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}

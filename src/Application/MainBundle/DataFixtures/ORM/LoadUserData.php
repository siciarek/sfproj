<?php

namespace Application\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var numeric 
     */
    protected $order = 2;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'enabled' => true,
                'username' => 'jsiciarek',
                'password' => 'pass',
                'email' => 'siciarek@gmail.com',
                'groups' => [
                    'Superadmins',
                ]
            ],
            [
                'enabled' => true,
                'username' => 'colak',
                'password' => 'pass',
                'email' => 'colak@gmail.com',
                'groups' => [
                    'Admins',
                ]
            ],
            [
                'enabled' => true,
                'username' => 'molak',
                'password' => 'pass',
                'email' => 'molak@gmail.com',
                'groups' => [
                    'Users',
                ]
            ],
        ];
        
        /**
         * @var Sonata\UserBundle\Entity\GroupManager $mngr
         */
        $mngr = $this->getContainer()->get('fos_user.user_manager');
        
        foreach($data as $o) {
            $user = $mngr->createUser();
            $user->setEnabled($o['enabled']);
            $user->setUsername($o['username']);
            $user->setEmail($o['email']);
            $user->setPlainPassword($o['password']);
            
            foreach($o['groups'] as $group) {
                $user->addGroup($this->getReference('group'.$group));  
            }
            $mngr->updateUser($user);
            $this->setReference('user' . $user->getUsername(), $user);
        }
        
    }
    
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    public function getContainer() {
        return $this->container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
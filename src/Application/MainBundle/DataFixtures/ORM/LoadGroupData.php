<?php

namespace Application\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var numeric 
     */
    protected $order = 1;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'name' => 'Users',
                'roles' => [
                    'ROLE_USER',
                ]
            ],
            [
                'name' => 'Admins',
                'roles' => [
                    'ROLE_ADMIN',
                ]
            ],
            [
                'name' => 'Superadmins',
                'roles' => [
                    'ROLE_SUPER_ADMIN',
                ]
            ],
        ];
        
        /**
         * @var Sonata\UserBundle\Entity\GroupManager $mngr
         */
        $mngr = $this->getContainer()->get('fos_user.group_manager');
        
        foreach($data as $o) {
            $group = $mngr->createGroup($o['name']);
            foreach($o['roles'] as $role) {
                $group->addRole($role);  
            }
            $mngr->updateGroup($group);
            $this->setReference('group' . $group->getName(), $group);
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
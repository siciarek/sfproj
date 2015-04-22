<?php

namespace Application\MainBundle\DataFixtures\ORM;

use Application\MainBundle\DataFixtures\BasicFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGroupData extends BasicFixture {
    
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
}
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
        $count = 100;
        
        $faker = $faker = \Faker\Factory::create('pl_PL');
        
        $data = [
            [
                'enabled' => true,
                'username' => 'jsiciarek',
                'firstname' => 'Jacek',
                'lastname' => 'Siciarek',
                'dob' => '1966-10-21',
                'gender' => \Sonata\UserBundle\Model\UserInterface::GENDER_MALE,
                'password' => 'pass',
                'email' => 'siciarek@gmail.com',
                'groups' => [
                    'Superadmins',
                ]
            ],
            [
                'enabled' => true,
                'username' => 'colak',
                'firstname' => 'Czesław',
                'lastname' => 'Olak',
                'dob' => '1985-04-11',
                'gender' => \Sonata\UserBundle\Model\UserInterface::GENDER_MALE,
                'password' => 'pass',
                'email' => 'colak@gmail.com',
                'groups' => [
                    'Admins',
                ]
            ],
            [
                'enabled' => true,
                'username' => 'molak',
                'firstname' => 'Marianna',
                'lastname' => 'Olak',
                'dob' => '1989-11-05',
                'gender' => \Sonata\UserBundle\Model\UserInterface::GENDER_FEMALE,
                'password' => 'pass',
                'email' => 'molak@gmail.com',
                'groups' => [
                    'Users',
                ]
            ],
        ];
        
        foreach(range(1, $count) as $i) {
            
            $firstname = $faker->firstNameMale;
            $lastname = $faker->lastNameMale;
            $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_MALE;
            
            if(rand(0, 1)) {
                $firstname = $faker->firstNameFemale;
                $lastname = $faker->lastNameFemale;
                $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_FEMALE;
            }
                        
            $firstname = trim($firstname);
            $lastname = trim($lastname);            
            $first = mb_substr($firstname, 0, 1);            
            $uname = $first . $lastname;
            
            @$username = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $uname));
            
            $dob = $faker->dateTimeBetween($startDate = '-40 years', $endDate = '-25 years')->format('Y-m-d');
            
            $data[] = [
                'enabled' => true,
                'username' => $username . $i,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'dob' => $dob,
                'gender' => $gender,
                'password' => 'pass',
                'email' => $username . $i . '@gmail.com',
                'groups' => [
                    'Users',
                ]
            ];
        }
        
        /**
         * @var Sonata\UserBundle\Entity\GroupManager $mngr
         */
        $mngr = $this->getContainer()->get('fos_user.user_manager');
        
        foreach($data as $o) {
            $user = $mngr->createUser();
            $user->setEnabled($o['enabled']);
            $user->setUsername($o['username']);
            $user->setFirstname($o['firstname']);
            $user->setLastname($o['lastname']);
            $user->setGender($o['gender']);
            $user->setEmail($o['email']);
            $user->setDateOfBirth(new \DateTime($o['dob']));
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
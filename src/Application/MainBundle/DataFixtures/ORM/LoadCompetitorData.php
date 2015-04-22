<?php

namespace Application\MainBundle\DataFixtures\ORM;

use Application\MainBundle\DataFixtures\BasicFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Application\MainBundle\Entity\Competitor;

class LoadCompetitorData extends BasicFixture {

    /**
     * @var numeric 
     */
    protected $order = 4;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $count = 24;

        $faker = \Faker\Factory::create('pl_PL');

        $root = new Competitor();
        $root->setId(0);
        $root->setName('Czesław Olak');
        $manager->persist($root);
 
        $this->setReference('competitor' . $root->getId(), $root);

        $nodes = [
            $root,
        ];

        $names[$root->getName()] = true;

        $range = range(1, $count);

        foreach ($range as $i) {

            do {
                $firstname = $faker->firstNameMale;
                $lastname = $faker->lastNameMale;
                $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_MALE;

                if (rand(0, 1)) {
                    $firstname = $faker->firstNameFemale;
                    $lastname = $faker->lastNameFemale;
                    $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_FEMALE;
                }
            
                $name = $firstname . ' ' . $lastname;

            } while (array_key_exists($name, $names));

            $obj = new Competitor();
            $obj->setName($firstname . ' ' . $lastname);
            $obj->setId($i);

            $obj->setChildNodeOf($nodes[array_rand($nodes)]);

            $manager->persist($obj);

            $names[$name] = true;
            $nodes[] = $obj;

            $this->setReference('competitor' . $i, $obj);
        }

        $manager->flush();
    }
}

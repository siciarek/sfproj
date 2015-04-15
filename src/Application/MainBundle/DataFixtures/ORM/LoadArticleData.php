<?php

namespace Application\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface {

    /**
     * @var numeric 
     */
    protected $order = 3;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $arcount = 100;
        $aucount = 100;

        $faker = \Faker\Factory::create('pl_PL');

        $creator = $this->getReference('user' . 'jsiciarek');

        $authors = [];

        foreach (range(1, $aucount) as $i) {
            do {
                $firstname = $faker->firstNameMale;
                $lastname = $faker->lastNameMale;
                $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_MALE;

                if (rand(0, 1)) {
                    $firstname = $faker->firstNameFemale;
                    $lastname = $faker->lastNameFemale;
                    $gender = \Sonata\UserBundle\Model\UserInterface::GENDER_FEMALE;
                }
            } while (array_key_exists($firstname . $lastname, $authors));

            $authors[$firstname . $lastname] = true;

            $info = implode("\n", $faker->paragraphs(2));
            $obj = new \Application\MainBundle\Entity\Author();
            $obj->setFirstName($firstname);
            $obj->setLastName($lastname);
            $obj->setInfo($info);

            $obj->setCreatedBy($creator);
            $obj->setUpdatedBy($creator);

            $manager->persist($obj);
            $manager->flush();
            $manager->clear();

            $this->setReference('author' . $i, $obj);
        }

        foreach (range(1, $arcount) as $i) {

            $obj = new \Application\MainBundle\Entity\Article();

            $obj->setCreatedBy($creator);
            $obj->setUpdatedBy($creator);

            foreach (['pl', 'en'] as $tr) {

                $title = $faker->sentence(4);
                $title = preg_replace('/\.$/', '', $title);
                $content = $faker->paragraphs(10);
                $content = implode("\n\n", $content);

                $obj->translate($tr)->setTitle($title);
                $obj->translate($tr)->setContent($content);

                $obj->mergeNewTranslations();
            }

            $au = [];
            foreach (range(1, rand(1, 3)) as $a) {
                do {
                    $a = rand(1, $aucount);
                } while (in_array($a, $au));

                $au[] = $a;
            }

            foreach ($au as $auid) {
                $author = $this->getReference('author' . $auid);
                $obj->addAuthor($author);
            }

            $manager->persist($obj);
            $manager->flush();
            $manager->clear();
            sleep(1);
        }
    }

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return $this->order;
    }

    public function getContainer() {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}

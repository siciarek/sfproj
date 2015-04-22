<?php

namespace Application\MainBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BasicFixture extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface {

    /**
     * @var numeric 
     */
    protected $order = 0;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        throw new \Exception('Method ' . __METHOD__ . ' is not implemented.');
    }

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

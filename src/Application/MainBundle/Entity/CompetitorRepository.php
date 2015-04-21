<?php

namespace Application\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Knp\DoctrineBehaviors\ORM as ORMBehaviors;

class CompetitorRepository extends EntityRepository
{
    use ORMBehaviors\Tree\Tree;
}


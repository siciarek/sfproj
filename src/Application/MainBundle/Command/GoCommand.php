<?php

namespace Application\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Application\MainBundle\Entity\Competitor;

class GoCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('go')
                ->setDescription('Just go.')
                ->addArgument(
                        'gen', InputArgument::OPTIONAL, 'Who do you want to greet?'
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $root = $em->getRepository('ApplicationMainBundle:Competitor')->getTree();
        $nodes = $em->getRepository('ApplicationMainBundle:Competitor')->findAll();

        echo 'digraph {' . PHP_EOL;
        $this->displayNode($root);

        foreach ($nodes as $n) {
            printf('%s [label="%s"]' . PHP_EOL, $n->getId(), $n->getName());
        }

        echo '}' . PHP_EOL;
    }

    public function displayNode($node) {
        $children = $node->getChildNodes();

        foreach ($children as $ch) {
            printf('%s -> %s' . PHP_EOL, $node->getId(), $ch->getId());
            if ($ch->getChildNodes()->count() > 0) {
                $this->displayNode($ch);
            }
        }
    }

}

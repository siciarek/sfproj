<?php

namespace Application\MainBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;

class DisplayGraph implements ContainerAwareInterface {

    public function __construct(ContainerInterface $container = null) {
        $this->setContainer($container);
    }
    
    public function getImageContent($graph, $format = 'png') {

        $input = escapeshellarg($graph);

        $dot = '/usr/bin/dot';

        $cmd = "echo $input | $dot -T$format";

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $content = $process->getOutput();
        
        return $content;
    }
    
    /**
     * @var ContainerInterface
     */
    protected $container;

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
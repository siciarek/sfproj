<?php

namespace Application\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;

/**
 * @Security("has_role('ROLE_USER')")
 * @Route("/graph")
 */
class GraphController extends Controller {

    /**
     * @Route("/render.{format}", name="graph.render")
     */
    public function renderAction($format = 'png') {

        $graph = <<<GRAPH
digraph {
    node  [ shape=circle, fontname="Helvetica bold", fontsize=24 ]

    0 -> {1 2 3}
    1 -> {4 5 6}
    2 -> {7 8 9}
    3 -> {10 11 12}
    8 -> {13 14 15}
    15 -> {16 17 18 19}
}
GRAPH;

        $input = escapeshellarg($graph);

        $dot = '/usr/bin/dot';

        $cmd = "echo $input | $dot -T$format";

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $output = $process->getOutput();
        $contentType = 'image/' . $format;

        $headers = [
            'Content-Type' => $contentType,
        ];
        
        $response = new \Symfony\Component\HttpFoundation\Response($output, 200, $headers);
        
        return $response;
    }

}

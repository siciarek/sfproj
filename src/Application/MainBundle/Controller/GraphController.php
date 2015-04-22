<?php

namespace Application\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        
        $size = 8;
        $matrix = [];

        for ($r = 0; $r < $size; $r++) {
            for ($c = 0; $c < $size; $c++) {
                $matrix[$r][$c] = $r === $c ? 0 : rand(0, 10) > 8 ? 1 : 0;
            }
        }

        
        
        $lines = [];

        for ($r = 0; $r < count($matrix); $r++) {
            $connected = [];

            for ($c = 0; $c < count($matrix[0]); $c++) {
                if ($matrix[$r][$c]) {
                    $connected[] = $c;
                }
            }

            if (count($connected) > 0) {
                $lines[] = sprintf('%s -> {%s}', $r, implode(' ', $connected));
            }
        }

        $grdef = implode("\n", $lines);

        $graph = <<<GRAPH
digraph {
    graph [ bgcolor=transparent ]
    node  [ shape=circle, fontname="Helvetica bold", fontsize=24, style=filled, fillcolor=yellow ]
    $grdef
}
GRAPH;

//        $input = escapeshellarg($graph);
//
//        $dot = '/usr/bin/dot';
//
//        $cmd = "echo $input | $dot -T$format";
//
//        $process = new Process($cmd);
//        $process->run();
//
//        if (!$process->isSuccessful()) {
//            throw new \RuntimeException($process->getErrorOutput());
//        }
//
//        $content = $process->getOutput();

        $content = $this->get('app.service.display.graph')->getImageContent($graph);
        
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $contentType = $finfo->buffer($content);

        $headers = [
            'Content-Type' => $contentType,
        ];

        return new Response($content, 200, $headers);
    }

}

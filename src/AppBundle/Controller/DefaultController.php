<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $input =
            '. . . . . . . . . . .
. . . . . . . . . . .
. . . . . . . . . . .
. . 9 . . . . . . . .
. . 9 . . . . . . . .
. . 9 . X . . . . . .
. . 9 . . . . . . . .
. . 9 9 9 9 9 9 . . .
. . 9 . . . . . . . .
. . 9 . . . . . . . .
. . 9 . . . . . . . .
. . 9 . . . . . . . .
. . 9 . . * . . . . .
. . 9 . . . . . . . .
. . . . . . . . . . .
. . . . . . . . . . .
. . . . . . . . . . .';
        $input =
'. . . . . . . . . . . .
. 9 9 9 . . . . . . . .
. . . 9 . . . . . . . .
. X . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . . . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 9 9 9 9 9 . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . . . . . . .
. . . 9 . . * . . . . .
. . . 9 . . . . . . . .
. . . 9 9 9 9 9 9 9 9 .
. . . 9 . . . . . . . .
. . . . . . . . . . . .';

        $outputTerrain =
'. . . . . . . . . . .
. R E S U L T . . . .
. . . T E R R A I N .
. . ^ . . . . . . . .
. . # . . . . . . . .
. . # . X . . . . . .
. . # \\ . . . . . . .
. . # # # # # > . . .
. . # / . . . . . . .
. . # . . . . . . . .
. . # . . . . . . . .
. . # . . . . . . . .
. . # . . * . . . . .
. . v . . . . . . . .
. . . . . . . . . . .
. . . . . . . . . . .
. . . . . . . . . . .';

        $pathfinder = $this->get('app.handler.pathfinder.lines');

        $output = $pathfinder->findPath($input, 'asciimap');

        dump($output);

        return [];
    }
}

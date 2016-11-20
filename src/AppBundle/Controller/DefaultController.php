<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\MapInputType;
use AppBundle\Entity\MapInput;

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
    public function indexAction(Request $request)
    {
//        $input =
//'. . . . . . . . . . . .
//. 9 9 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. X . 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. . . . . . . . . . . .
//. . . 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. . . 9 9 9 9 9 9 . . .
//. . . 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. . . 9 . . . . . . . .
//. . . 9 . . * . . . . .
//. . . 9 . . . . . . . .
//. . . 9 9 9 9 9 9 9 9 .
//. . . 9 . . . . . . . .
//. . . . . . . . . . . .';

        $form = $this->createForm(MapInputType::class, null, [
            'action' => $this->generateUrl('index'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        /** @var MapInput $formData */
        $formData = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $pathfinder = $this->get('app.handler.pathfinder.lines');
            $output = $pathfinder->findPath($formData->getTerrain(), 'asciimap');
        }

        return ['form' => $form->createView()];
    }
}

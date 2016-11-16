<?php

namespace AppBundle\Handler\Pathfinder;

use AppBundle\Helper\InputParser\Factory as InputParserFactory;
use AppBundle\Model\Pathfinder\Position;
use AppBundle\Model\Pathfinder\Node;
use AppBundle\Model\Pathfinder\Nodes;
use AppBundle\Model\Manager as ModelManager;
use AppBundle\Model\World\Map;

/**
 * Class Linefinder
 * @package AppBundle\Handler\Pathfinder
 */
class Linefinder
{
    /**
     * @var InputParserFactory
     */
    private $inputParser;

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * Linefinder constructor.
     * @param InputParserFactory $parser
     * @param ModelManager $modelManager
     */
    public function __construct(InputParserFactory $parser, ModelManager $modelManager)
    {
        $this->inputParser = $parser;
        $this->modelManager = $modelManager;
    }


    public function findPath($input, $format)
    {
        $parser = $this->inputParser->getParserFromInputType($format);
        $data = $parser->parse($input);

        /** @var Map $map */
        $map = $data['map'];
        /** @var Position $start */
        $start = $data['startpoint'];
        /** @var Position $target */
        $target = $data['targetpoint'];

        $this->findLine($start, $target, $map);
    }

    /**
     * One pass of the algorithm finding the shortest line from A to B.
     * Not taking into account change of direction / turns.
     * Not necessarily the best one we're looking for.
     *
     * @param Position $star
     * @param Position $target
     */
    private function findLine(Position $start, Position $target, Map $map)
    {
        // init the empty lists
        $openList = $this->modelManager->pathfinder()->nodes();
        $closedList = $this->modelManager->pathfinder()->nodes();

        // create start node
        $node = $this->modelManager->pathfinder()->node();
        $node->getPosition()->setX($start->getX());
        $node->getPosition()->setY($start->getY());
        $node->setNodeId($this->generateNodeId($node));
        $this->calcAndSetNodeCosts($node, $openList, $closedList, $target, $map);

        // put start node into open list
        $openList->set($node);

        // at this point we have everything set up to start iterating through everything to find
        //  the shortest path
        $searching = true;
        while ($searching) {
            $node = $openList->getCheapest();
            $this->putAdjacentNodes($node, $closedList, $openList, $map, $start, $target);

            $closedList->set($node);
            $openList->remove($node);

            if (($node->getPosition()->getX() == $target->getX()) && ($node->getPosition()->getY() == $target->getY())) {
                $searching = false;
            }

//            $map->set($node->getPosition()->getX(), $node->getPosition()->getY(), $node->getCost());
//            echo "<pre>\n";
//            for ($y = 0; $y < $map->getSizeY(); $y++) {
//                for ($x = 0; $x < $map->getSizeX(); $x++) {
//                    $s = $map->get($x, $y);
//                    $s = strlen($s) == 1 ? '  ' . $s : ' ' . $s;
//                    echo $s;
//                }
//                echo "\n";
//            }
//            echo "\n\n\n</pre>";
        }
        while (null !== $node) {
            $map->set($node->getPosition()->getX(), $node->getPosition()->getY(), 'X');
            $node = $closedList->get($node->getParentNodeId());
        }
        echo "<pre>\n";
        for ($y = 0; $y < $map->getSizeY(); $y++) {
            for ($x = 0; $x < $map->getSizeX(); $x++) {
                echo $map->get($x, $y) . " ";
            }
            echo "\n";
        }
        echo "\n\n\n</pre>";
    }

    /**
     * Adds all four directly adjacent nodes (up, left, down, right) of the given one to the open list,
     * if applicable.
     *
     * @param Node $current
     * @param Nodes $closed
     * @param Nodes $open
     */
    private function putAdjacentNodes(Node $current, Nodes $closed, Nodes $open, Map $map, Position $start, Position $target)
    {
        $nodes = [];
        $x = $current->getPosition()->getX();
        $y = $current->getPosition()->getY();

        // generate nodes for the four directly adjacent coordinates
        $t = $this->modelManager->pathfinder()->node();
        $t->getPosition()->setX($x)->setY($y - 1);
        $t->setNodeId($this->generateNodeId($t));
        $nodes[0] = $t;

        $t = $this->modelManager->pathfinder()->node();
        $t->getPosition()->setX($x + 1)->setY($y);
        $t->setNodeId($this->generateNodeId($t));
        $nodes[1] = $t;

        $t = $this->modelManager->pathfinder()->node();
        $t->getPosition()->setX($x)->setY($y + 1);
        $t->setNodeId($this->generateNodeId($t));
        $nodes[2] = $t;

        $t = $this->modelManager->pathfinder()->node();
        $t->getPosition()->setX($x - 1)->setY($y);
        $t->setNodeId($this->generateNodeId($t));
        $nodes[3] = $t;

        // now check if they're not already in the closed list and within the bounds of the map,
        //  and add the node to the open list if so
        foreach ($nodes as $node) {
            /** @var Node $node */
            if (
                (!$closed->contains($node))
                && ($node->getPosition()->getX() < $map->getSizeX())
                && ($node->getPosition()->getY() < $map->getSizeY())
                && ($node->getPosition()->getX() >= 0)
                && ($node->getPosition()->getY() >= 0)
            ) {
                $node->setParentNodeId($current->getNodeId());

                $this->calcAndSetNodeCosts($node, $open, $closed, $target, $map);

                $open->set($node);

            }
        }
    }

    private function calcAndSetNodeCosts(Node $node, Nodes $open, Nodes $closed, Position $target, Map $map)
    {
        // H cost (heuristic distance cost from node to target)
        $node->setHCost($this->calcHCost($node->getPosition(), $target));

        // F cost (cost of the current path from start to current node, not accounting for turns
        //  as we need later for the real path cost)
        $parentNode = $this->getParentNode($node, $open, $closed);
        if (null !== $parentNode) {
            $node->setFCost($parentNode->getFCost() + 1); // ???
        }

        // total cost, which is "H + F + terrain modifier - direction vector"
        $tCost = 10 * ((int)$map->get($node->getPosition()->getX(), $node->getPosition()->getY()));
        $dvNode = $this->getDirectionVector($node, $open, $closed);

        $dvParent = $this->modelManager->pathfinder()->position();
        if (null !== $parentNode) {
            $dvParent = $this->getDirectionVector($parentNode, $open, $closed);
        }

        $dCost = 0;
        if (($dvNode->getX() == $dvParent->getX()) && ($dvNode->getY() == $dvParent->getY())) {
            $dCost = -1; // !!!
        }
//        else { $dCost = 70; }

        $node->setCost($node->getHCost() + $node->getFCost() + $tCost + $dCost);
    }

    /**
     * Simplified version of getting the (heuristic) cost (distance to) the target node form the current one.
     * As we don't have diagonals in this implementation it's basically the delta of X and Y coordinates.
     *
     * @param Position $a
     * @param Position $b
     * @return integer
     */
    private function calcHCost(Position $a, Position $b)
    {
        $deltaX = abs($a->getX() - $b->getX());
        $deltaY = abs($a->getY() - $b->getY());
        return $deltaX + $deltaY;
    }

    /**
     * @param Node $node
     * @param Nodes $open
     * @param Nodes $closed
     * @return Position
     */
    private function getDirectionVector(Node $node, Nodes $open, Nodes $closed)
    {
        $vector = $this->modelManager->pathfinder()->position();
        $vector->setX(0)->setY(0);

        $parentNode = $this->getParentNode($node, $open, $closed);
        if ($parentNode !== null) {
            $vector->setX($node->getPosition()->getX() - $parentNode->getPosition()->getX());
            $vector->setY($node->getPosition()->getY() - $parentNode->getPosition()->getY());
        }

        return $vector;
    }

    /**
     * @param Node $node
     * @param Nodes $open
     * @param Nodes $closed
     * @return Node|null
     */
    private function getParentNode(Node $node, Nodes $open, Nodes $closed)
    {
        $parentNode = null;

        // check if the node has a parent and it exists in one of the lists
        if (($node->getParentNodeId() !== null) && (($open->containsId($node->getParentNodeId())) || ($closed->containsId($node->getParentNodeId())))) {
            // get the parent node from the list it's in
            $parentNode = $open->containsId($node->getParentNodeId()) ? $open->get($node->getParentNodeId()) : $closed->get($node->getParentNodeId());
        }

        return $parentNode;
    }

    /**
     * Calculates the full, true cost of the given line/path, taking into account turns / change in direction.
     */
    private function calcFullLineCost()
    {
    }

    /**
     * @param Node $node
     * @return string
     */
    private function generateNodeId(Node $node)
    {
        return 'N:' . $node->getPosition()->getX() . ':' . $node->getPosition()->getY();
    }
}

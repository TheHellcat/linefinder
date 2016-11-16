<?php

namespace AppBundle\Model\Pathfinder;

use Doctrine\Common\Collections\ArrayCollection;

class Nodes
{
    /**
     * @var Node[]|ArrayCollection
     */
    private $nodes;

    /**
     * Nodes constructor.
     */
    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }


    /**
     * @param Node $node
     */
    public function set(Node $node)
    {
        $this->nodes->set($node->getNodeId(), $node);
    }

    /**
     * @param string $nodeID
     * @return Node|null
     */
    public function get($nodeID)
    {
        return $this->nodes->get($nodeID);
    }

    /**
     * @param Node $node
     */
    public function remove(Node $node)
    {
        $this->nodes->remove($node->getNodeId());
    }

    /**
     * @param Node $node
     * @return bool
     */
    public function contains(Node $node)
    {
        return $this->nodes->containsKey($node->getNodeId());
    }

    /**
     * @param string $node
     * @return bool
     */
    public function containsId($nodeId)
    {
        return $this->nodes->containsKey($nodeId);
    }

    /**
     * @return Node|null
     */
    public function getCheapest()
    {
        $returnNode = null;
        $minCost = -1;

        foreach ($this->nodes as $node) {
            if (($node->getCost() < $minCost) || (-1 == $minCost)) {
                $returnNode = $node;
                $minCost = $node->getCost();
            }
        }

        return $returnNode;
    }
}

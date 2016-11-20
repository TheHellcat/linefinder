<?php

namespace AppBundle\Model\Pathfinder;

class Node
{
    /**
     * @var string
     */
    private $nodeId;

    /**
     * @var string
     */
    private $parentNodeId;

    /**
     * @var Position
     */
    private $position;

    /**
     * @var integer
     */
    private $cost;

    /**
     * @var integer
     */
    private $hCost;

    /**
     * @var integer
     */
    private $fCost;

    /**
     * @var Position
     */
    private $directionVector;


    public function __construct()
    {
        $this->position = new Position();
    }


    /**
     * @return string
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * @param string $nodeId
     * @return Node
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getParentNodeId()
    {
        return $this->parentNodeId;
    }

    /**
     * @param string $parentNodeId
     * @return Node
     */
    public function setParentNodeId($parentNodeId)
    {
        $this->parentNodeId = $parentNodeId;
        return $this;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return Node
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return Node
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return int
     */
    public function getHCost()
    {
        return $this->hCost;
    }

    /**
     * @param int $hCost
     * @return Node
     */
    public function setHCost($hCost)
    {
        $this->hCost = $hCost;
        return $this;
    }

    /**
     * @return int
     */
    public function getFCost()
    {
        return $this->fCost;
    }

    /**
     * @param int $fCost
     * @return Node
     */
    public function setFCost($fCost)
    {
        $this->fCost = $fCost;
        return $this;
    }

    /**
     * @return Position
     */
    public function getDirectionVector()
    {
        return $this->directionVector;
    }

    /**
     * @param Position $directionVector
     * @return Node
     */
    public function setDirectionVector($directionVector)
    {
        $this->directionVector = $directionVector;
        return $this;
    }
}

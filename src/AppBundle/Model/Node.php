<?php

namespace AppBundle\Model;

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
}

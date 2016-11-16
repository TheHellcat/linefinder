<?php

namespace AppBundle\Model\Pathfinder;


class Factory
{
    /**
     * @var array
     */
    private $factory;

    /**
     * Factory constructor.
     */
    public function __construct()
    {
        $this->factory = [];
    }


    /**
     * @return Node
     */
    public function node()
    {
        return new Node();
    }

    /**
     * @return Nodes
     */
    public function nodes()
    {
        return new Nodes();
    }

    /**
     * @return Position
     */
    public function position()
    {
        return new Position();
    }
}

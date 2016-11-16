<?php

namespace AppBundle\Model\Pathfinder;

class Position
{
    /**
     * @var integer
     */
    private $x;

    /**
     * @var integer
     */
    private $y;


    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Position
     */
    public function setX($x)
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Position
     */
    public function setY($y)
    {
        $this->y = $y;
        return $this;
    }
}

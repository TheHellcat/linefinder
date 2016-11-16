<?php

namespace AppBundle\Model\World;


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
     * @return Map
     * @param integer $sizeX
     * @param integer $sizeY
     */
    public function map($sizeX, $sizeY)
    {
        return new Map($sizeX, $sizeY);
    }
}

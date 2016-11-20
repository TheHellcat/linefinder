<?php

namespace AppBundle\Entity;

class MapInput
{
    /**
     * @var string
     */
    private $terrain;


    /**
     * @return string
     */
    public function getTerrain()
    {
        return $this->terrain;
    }

    /**
     * @param string $terrain
     * @return MapInput
     */
    public function setTerrain($terrain)
    {
        $this->terrain = $terrain;
        return $this;
    }
}

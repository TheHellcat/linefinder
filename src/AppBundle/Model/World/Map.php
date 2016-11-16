<?php

namespace AppBundle\Model\World;

/**
 * Class Map
 * @package AppBundle\Model
 */
class Map
{
    /**
     * @var array
     */
    private $mapData;

    /**
     * @var integer
     */
    private $sizeX;

    /**
     * @var integer
     */
    private $sizeY;


    /**
     * Map constructor.
     * @param integer $sizeX
     * @param integer $sizeY
     */
    public function __construct($sizeX, $sizeY)
    {
        $a = [];
        $this->mapData = [];

        for( $i=0; $i<$sizeY; $i++) {
            $a[$i]='';
        }

        for( $i=0; $i<$sizeX; $i++) {
            $this->mapData[$i]='';
        }

        $this->sizeX = $sizeX;
        $this->sizeY = $sizeY;
    }


    /**
     * @param integer $x
     * @param integer $y
     * @param string $value
     */
    public function set($x, $y, $value)
    {
        // TODO: check if X or Y out of bounds
        $this->mapData[$x][$y] = $value;
    }

    /**
     * @param integer $x
     * @param integer $y
     * @return string
     */
    public function get($x, $y)
    {
        // TODO: check if X or Y out of bounds
        return $this->mapData[$x][$y];
    }

    /**
     * @return integer
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * @return integer
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }
}

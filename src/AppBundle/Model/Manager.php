<?php

namespace AppBundle\Model;

/**
 * Class Manager
 * @package AppBundle\Model
 */
class Manager
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
     * @return World\Factory
     */
    public function world()
    {
        if (!isset($this->factory[__FUNCTION__])) {
            $this->factory[__FUNCTION__] = new World\Factory();
        }
        return $this->factory[__FUNCTION__];
    }

    /**
     * @return Pathfinder\Factory
     */
    public function pathfinder()
    {
        if (!isset($this->factory[__FUNCTION__])) {
            $this->factory[__FUNCTION__] = new Pathfinder\Factory();
        }
        return $this->factory[__FUNCTION__];
    }
}

<?php

namespace AppBundle\Helper\InputParser;

use AppBundle\Model\World\Map;

/**
 * Interface ParserInterface
 * @package AppBundle\Helper\InputParser
 */
interface ParserInterface
{
    /**
     * @param $input
     * @return Map
     */
    public function parse($input);
}

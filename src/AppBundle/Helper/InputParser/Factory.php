<?php

namespace AppBundle\Helper\InputParser;

use AppBundle\Helper\InputParser\Exception\ParserErrorInvalidInputFormat;
use AppBundle\Model\Manager as ModelManager;

/**
 * Class Factory
 * @package AppBundle\Helper\InputParser
 */
class Factory
{
    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * @var array
     */
    private $factory;

    /**
     * Factory constructor.
     * @param ModelManager $modelManager
     */
    public function __construct(ModelManager $modelManager)
    {
        $this->factory = [];
        $this->modelManager = $modelManager;
    }


    /**
     * @return AsciiMap
     */
    public function getAsciiMapParser()
    {
        if (!isset($this->factory[__FUNCTION__])) {
            $this->factory[__FUNCTION__] = new AsciiMap($this->modelManager);
        }
        return $this->factory[__FUNCTION__];
    }


    /**
     * @param $type
     * @return ParserInterface|null
     * @throws ParserErrorInvalidInputFormat
     */
    public function getParserFromInputType($type)
    {
        $returnClass = null;

        switch ($type) {
            case 'asciimap':
                $returnClass = $this->getAsciiMapParser();
                break;
            default:
                throw new ParserErrorInvalidInputFormat('Unknown input format: ' . $type);
        }

        return $returnClass;
    }
}

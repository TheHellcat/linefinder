<?php

namespace AppBundle\Helper\InputParser;

use AppBundle\Model\World\Map;
use AppBundle\Model\Manager as ModelManager;

/**
 * Class AsciiMap
 * @package AppBundle\Helper\InputParser
 */
class AsciiMap implements ParserInterface
{
    /**
     * @var ModelManager
     */
    private $modelManager;

    public function __construct(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
    }


    /**
     * @param string $input
     * @return array
     */
    public function parse($input)
    {
        $startPoint = $this->modelManager->pathfinder()->position();
        $targetPoint = $this->modelManager->pathfinder()->position();

        $t = str_replace("\r", '', $input);
        $y = explode("\n", $t);
        $sizeY = count($y);

        $sizeX = count(explode(' ', $y[0]));

        $map = $this->modelManager->world()->map($sizeX, $sizeY);

        for ($i = 0; $i < $sizeY; $i++) {
            $x = explode(' ', $y[$i]);
            for ($j = 0; $j < $sizeX; $j++) {
                $map->set($j, $i, $x[$j]);
                if ('*' == $x[$j]) {
                    $startPoint->setX($j);
                    $startPoint->setY($i);
                }
                if ('X' == $x[$j]) {
                    $targetPoint->setX($j);
                    $targetPoint->setY($i);
                }
            }
        }

        $returnData = [];
        $returnData['startpoint'] = $startPoint;
        $returnData['targetpoint'] = $targetPoint;
        $returnData['map'] = $map;
        return $returnData;
    }
}

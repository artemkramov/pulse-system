<?php
namespace tests\codeception\backend;


use backend\components\Jpgraph;
use yii\base\ErrorException;

class JpgraphTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testJpgraphFactory()
    {
        $graph = new Jpgraph(140, 140, 10, 'PieGraph', true);
        $pieGraph = $graph->getGraph();
        $expectedValue = 'PieGraph';
        $this->assertInstanceOf($expectedValue, $pieGraph);
    }
}
<?php
namespace tests\codeception\backend;


use backend\models\BullionType;

class BullionTypeTest extends \yii\codeception\TestCase
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    public $appConfig;

    protected function _before()
    {
        $this->tester = new BullionType();
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
    }

    protected function _after()
    {
        $this->tester = null;
    }

    public function testGetAveragePrice()
    {
        $this->tester->metal_parse_slug = 'gold';
        $expectedValue = 37.252;
        $this->assertEquals($expectedValue, $this->tester->getAveragePrice());
    }
}
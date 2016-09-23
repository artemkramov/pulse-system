<?php
namespace tests\codeception\backend;


use backend\models\Location;
use backend\models\Product;
use common\components\Number;

class LocationTest extends \yii\codeception\TestCase
{
    public $appConfig;
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    public function testGetWeightByMetal()
    {
        $this->tester = Location::findOne(3);
        $bullionTypeID = 2;
        $expectedValue = 0.04;
        $this->assertEquals($expectedValue, $this->tester->getWeightByBullionType($bullionTypeID));
        $bullionTypeID = 1;
        $expectedValue = 0;
        $this->assertEquals($expectedValue, $this->tester->getWeightByBullionType($bullionTypeID));
        $expectedValue = Number::convertFromDB($expectedValue);
        $this->assertEquals($expectedValue, $this->tester->getWeightByBullionType($bullionTypeID, true));
    }

    public function testGetWeight()
    {
        $this->tester = Location::findOne(3);
        $expectedValue = 0.04;
        $this->assertEquals($expectedValue, $this->tester->getWeight());
    }

    public function testPercentageByMetal()
    {
        $this->tester = Location::findOne(3);
        $bullionTypeID = 2;
        $expectedValue = 1;
        $this->assertEquals($expectedValue, $this->tester->getWeightPercentageByBullionType($bullionTypeID));
        $bullionTypeID = 1;
        $expectedValue = Number::convertFromDB(0);
        $this->assertEquals($expectedValue, $this->tester->getWeightPercentageByBullionType($bullionTypeID, true));
    }

    public function testGetTotalWeightByMetal()
    {
        $this->tester = Location::findOne(3);
        Product::deleteAll(['not in', 'id', [9, 10, 11, 12]]);
        $expectedValue = 0.04;
        $bullionTypeID = 2;
        $this->assertEquals($expectedValue, $this->tester->getTotalWeightByBullionType($bullionTypeID));
    }

    protected function _before()
    {
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
    }

    protected function _after()
    {
        $this->tester = null;
    }
}
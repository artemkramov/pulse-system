<?php
namespace tests\codeception\backend;


use backend\models\BullionType;
use backend\models\Location;
use backend\models\Product;

class ProductTest extends \yii\codeception\TestCase
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;
    public $appConfig;

    protected function _before()
    {
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
        $this->tester = new Product();
    }

    protected function _after()
    {
        $this->tester = null;
    }

    public function testGetProductValue()
    {
        $this->initTester();

        $expectedValue = 0;
        $this->assertEquals($expectedValue, $this->tester->getValue());
    }

    public function testWeightConversion()
    {
        $this->initTester();
        $expectedFromGrams = 0.0311;
        $this->assertEquals($expectedFromGrams, $this->tester->getWeightInKg());

        $this->tester->weight_amount = 2;
        $this->tester->weight_measure = 'troy';
        $expectedFromTroys = 0.0622;
        $this->assertEquals($expectedFromTroys, $this->tester->getWeightInKg());
    }

    public function testGetProductPriceExclVat()
    {
        $this->initTester();
        $this->tester->amount = 8;
        $this->tester->setDateToStorageAdded('2016-01-01');
        $this->tester->setDatePeriodEnd('2016-03-31');
        $this->tester->setTariff(0.75);
        $expectedPrice = 21.43;
        $this->assertEquals($expectedPrice, $this->tester->getPriceExclVAT());
    }

    public function testGetProductPriceVatNotEmpty()
    {
        $this->initTester();
        $this->tester->amount = 8;
        $this->tester->setDateToStorageAdded('2016-01-01');
        $this->tester->setDatePeriodEnd('2016-03-31');
        $this->tester->setTariff(0.75);

        $post = [
            'Product' => [
                'location_id' => 1
            ]
        ];
        $this->tester->load($post);
        $expectedPrice = 4.50;
        $this->assertEquals($expectedPrice, $this->tester->getPriceVAT());
    }

    public function testGetProductPriceVatEmpty()
    {
        $this->initTester();
        $this->tester->amount = 8;
        $this->tester->setDateToStorageAdded('2016-01-01');
        $this->tester->setDatePeriodEnd('2016-03-31');
        $this->tester->setTariff(0.75);
        $post = [
            'Product' => [
                'location_id' => 2
            ]
        ];
        $this->tester->load($post);
        $expectedPrice = 0;
        $this->assertEquals($expectedPrice, $this->tester->getPriceVAT());
    }

    public function testGetProductPriceInclVat()
    {
        $this->initTester();
        $this->tester->amount = 8;
        $this->tester->setAveragePrice(37.252);
        $this->tester->setDateToStorageAdded('2016-01-01');
        $this->tester->setDatePeriodEnd('2016-03-31');
        $this->tester->setTariff(0.75);

        $post = [
            'Product' => [
                'location_id' => 1
            ]
        ];
        $this->tester->load($post);
        $expectedPrice = 25.93;
        $this->assertEquals($expectedPrice, $this->tester->getPriceInclVAT());
    }


    private function initTester()
    {
        $this->tester->weight_amount = 31.1;
        $this->tester->weight_measure = 'gramm';
        $this->tester->percentage = 100;
        $bullionType = BullionType::find()->where(['metal_parse_slug' => 'gold'])->one();
        $post = [
            'Product' => [
                'bullion_type_id' => $bullionType->id
            ]
        ];
        $this->tester->load($post);
    }
}
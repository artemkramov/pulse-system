<?php
namespace tests\codeception\backend;


use backend\models\Customer;

class CustomerTest extends \yii\codeception\TestCase
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    public $appConfig;

    protected function _before()
    {
        $this->tester = new Customer();
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
    }

    protected function _after()
    {
        $this->tester = null;
    }

    public function testGetCustomerTariffPerMetal()
    {
        $customerID = 19;
        $bullionTypeID = 2;
        $expectedTariff = 0.75;
        $this->tester = Customer::findOne(19);
        $post = [
            'Customer' => [
                'tariffs' => [
                    'value' => [
                        1 => $expectedTariff
                    ],
                    'customer_id' => [
                        1 => $customerID
                    ],
                    'bullion_type_id' => [
                        1 => $bullionTypeID
                    ]
                ]
            ]
        ];
        $this->tester->load($post);
        $this->tester->save(false);
        $this->tester = Customer::findOne(19);
        $expectedValue = 1;
        $this->assertEquals($expectedValue, count($this->tester->tariffs));
        $this->assertEquals($expectedTariff, $this->tester->getTariffPriceForBullionType($bullionTypeID));
    }
}
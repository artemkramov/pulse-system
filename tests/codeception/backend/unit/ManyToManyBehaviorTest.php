<?php
namespace tests\codeception\backend;


use backend\models\Customer;

class ManyToManyBehaviorTest extends \yii\codeception\TestCase
{

    public $appConfig;

    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    public function testResetManyToMany()
    {
        $customer = Customer::findOne(1);
        $post = [
            'Customer' => [
                'product_ids' => []
            ]
        ];
        $this->assertTrue($customer->load($post), 'Load POST data');
        $this->assertTrue($customer->save(false), 'Save model');

        $customer = Customer::findOne(1);
        $this->assertEquals(0, count($customer->products));

    }

    public function testSaveManyToMany()
    {
        $customer = Customer::findOne(1);

        $post = [
            'Customer' => [
                'product_ids' => [9, 10]
            ]
        ];
        $this->assertEquals(0, count($customer->products));

        $this->assertTrue($customer->load($post), 'Load POST data');
        $this->assertTrue($customer->save(false), 'Save model');


        $customer = Customer::findOne(1);
        $this->assertEquals(2, count($customer->products));
    }



    protected function _before()
    {
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
    }

    // tests

    protected function _after()
    {
    }
}
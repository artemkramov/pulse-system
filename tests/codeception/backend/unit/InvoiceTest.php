<?php
namespace tests\codeception\backend;


use backend\components\PriceParserHelper;
use backend\models\Invoice;
use backend\models\Product;

class InvoiceTest extends \yii\codeception\TestCase
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    public $appConfig;

    protected function _before()
    {
        $this->tester = new Invoice();
        $this->appConfig = '@tests' . DIRECTORY_SEPARATOR . 'codeception' . DIRECTORY_SEPARATOR . 'backend' .
            DIRECTORY_SEPARATOR . 'unit' . DIRECTORY_SEPARATOR . '_config.php';
    }

    protected function _after()
    {
        $this->tester = null;
    }

    public function testIfDateIsReadyForInvoice()
    {
        $dateNotReadyYesterday = date('Y-m-d', strtotime('-1 day'));
        $dateNotReadyMonth = date('Y-m-d', strtotime('-1 months'));
        $dateNotReadyTwoMonth = date('Y-m-d', strtotime('-2 months'));
        $dateReadyThreeMonth = date('Y-m-d', strtotime('-3 months'));
        $dateReadyThreeMonthPlusDay = date('Y-m-d', strtotime('+10 day', strtotime($dateReadyThreeMonth)));

        $this->assertFalse(Invoice::isReadyForCreating($dateNotReadyYesterday));
        $this->assertFalse(Invoice::isReadyForCreating($dateNotReadyMonth));
        $this->assertFalse(Invoice::isReadyForCreating($dateNotReadyTwoMonth));
        $this->assertTrue(Invoice::isReadyForCreating($dateReadyThreeMonth));
        $this->assertTrue(Invoice::isReadyForCreating($dateReadyThreeMonthPlusDay));
    }

    public function testDateDifferenceInDays()
    {
        $startDate = '2016-01-01';
        $endDate = '2016-03-31';
        $expectedValue = 90;
        $this->assertEquals($expectedValue, Invoice::getDateDifferenceInDays($startDate, $endDate));
    }


}
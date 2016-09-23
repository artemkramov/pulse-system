<?php
namespace tests\codeception\backend;


use backend\components\PriceParserHelper;
use keltstr\simplehtmldom\SimpleHTMLDom as SHD;

class PriceParserTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\codeception\backend\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester = new PriceParserHelper();
    }

    protected function _after()
    {
        $this->tester = null;
    }

    public function testGetParseRequestUrl()
    {
        $metal = 'gold';
        $expectedUrl = 'http://lbma.oblive.co.uk/table?metal=gold&year=2016&type=daily';
        $this->tester->setYear(2016);
        $this->assertEquals($expectedUrl, $this->tester->getRequestUrl($metal));
    }

    public function testGetParsedAveragePriceHTMLStructure()
    {
        $metals = [
            'gold', 'silver', 'palladium', 'platinum'
        ];
        $expectedType = 'float';
        foreach ($metals as $metal) {
            $this->assertInternalType($expectedType, $this->tester->getParsedAmount($metal), 'Parsing of the page with metal: ' . $metal);
        }
    }

    public function testGetParsedAveragePrice()
    {
        $metals = [
            'gold' => 1209.538, 'silver' => 17.68870, 'platinum' => 951.1, 'palladium' => 537.905
        ];
        $pathToHTML = \Yii::getAlias('@tests') . DIRECTORY_SEPARATOR . "_data" . DIRECTORY_SEPARATOR . "averageSum" . DIRECTORY_SEPARATOR;
        foreach ($metals as $metal => $expectedAmount) {
            $path = $pathToHTML . "table_" . $metal . ".html";
            if (file_exists($path)) {
                $amount = $this->tester->getAmountFromHtml(SHD::file_get_html($path));
                $this->assertEquals($expectedAmount, $amount);
            }
            else {
                $this->assertTrue(false, 'Don\'t find a template for a metal: ' . $metal);
            }
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 7/8/16
 * Time: 9:18 AM
 */

namespace backend\components;


use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\FileHelper;

/**
 * Class for generating graphs from server side
 * */
class Jpgraph
{
    /**
     * Path to library folder
     * @var string
     */
    private $jpgraphPath = 'jpgraph';

    /**
     * Graph object
     * @var \Graph
     */
    private $graph;

    /**
     * Used graphs
     * @var array
     */
    private $libraries = [
        'pie'
    ];

    /**
     * Folder where temporary files will be created
     * @var string
     */
    private $tmpFolder;

    /**
     * Path to temporary image file
     * @var string
     */
    private $tmpFile;

    function __construct($xSize, $ySize, $imgLife, $graphType, $stream = true)
    {
        require_once $this->jpgraphPath . DIRECTORY_SEPARATOR . 'jpgraph.php';
        foreach ($this->libraries as $library) {
            $library = 'jpgraph_' . $library;
            require_once $this->jpgraphPath . DIRECTORY_SEPARATOR . $library . '.php';
        }
        $this->graph = call_user_func_array([self::class, 'buildGraph'], func_get_args());
        $this->tmpFolder = \Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads'
            . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'jpgraph' . DIRECTORY_SEPARATOR;
        if (!file_exists($this->tmpFolder)) {
            FileHelper::createDirectory($this->tmpFolder);
        }
        $this->tmpFile = $this->tmpFolder . uniqid('graph') . '.png';
    }

    /**
     * Build Graph object due to given type and parameters
     * @param $xSize
     * @param $ySize
     * @param $imgLife
     * @param $graphType
     * @param $stream
     * @return \Graph
     * @throws ErrorException
     */
    public static function buildGraph($xSize, $ySize, $imgLife, $graphType, $stream)
    {
        $graphType = '\\' . $graphType;
        if (class_exists($graphType)) {
            return new $graphType($xSize, $ySize, $imgLife, $stream);
        } else {
            throw new ErrorException('Undefined graph class name');
        }
    }

    public function __destruct()
    {
        if (file_exists($this->tmpFile)) {
            unlink($this->tmpFile);
        }
    }

    /**
     * Add bar plot to our graph
     * @param $data
     */
    public function addBarPlot($data)
    {
        $this->graph->SetScale('textlin');
        $piePlot = new \PiePlot($data['data']);
        $piePlot->SetLegends($data['legends']);
        $piePlot->SetLabels($data['labels']);
        $piePlot->SetGuideLines(true, false);
        $piePlot->SetGuideLinesAdjust(1.5);
        $piePlot->SetLabelType(PIE_VALUE_PER);
        $piePlot->value->Show();
        $piePlot->value->SetFormat('%2.1f%%');
        $this->graph->Add($piePlot);
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->graph->title->Set($title);
    }

    /**
     * Generate graph and returns the path to created image file
     * @return string
     */
    public function execute()
    {
        $this->graph->Stroke($this->tmpFile);
        return $this->tmpFile;
    }

    /**
     * @return \Graph|mixed
     */
    public function getGraph()
    {
        return $this->graph;
    }


}
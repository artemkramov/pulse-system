<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/31/16
 * Time: 1:12 PM
 */

namespace backend\widgets\multiple_bean;


use backend\components\MultipleBeanHelper;
use yii\base\Widget;

/**
 * Widget for manipulating with multiple beans
 * For example, when user has multiple addresses, emails, files
 * @author Artem Kramov
 */
class MultipleBean extends Widget
{
    /** Current model for which this widget is used
     * @var object
     */
    public $model;

    /** Attribute of the model that represent the related beans
     * @var string
     */
    public $attribute;

    /** Title of the widget
     * @var string
     */
    public $title;

    /** Minimum count of the related bean
     * @var integer
     */
    public $min;

    /** Parameter for checking if the add button must be visible
     * @var bool */
    public $enableAddOption = true;

    /** View name for the widget
     * @var string
     */
    private $viewName;

    /** Template keyword by which we replace the counter of each bean
     * @var string
     */
    private $templateReplaceKeyword = "{{template_replace_keyword}}";

    public function init()
    {
        parent::init();
        $this->viewName = "view";
        $this->registerAssets();
    }

    /**
     * Main method where the main logic is formed
     * Called on widget use
     * @return string
     */
    public function run()
    {
        $field = $this->attribute;
        /* Get current related beans of the model */
        $currentItems = $this->model->$field;
        if (!is_array($currentItems)) {
            $currentItems = [$currentItems];
        }
        /* Helper is used to call the action which will render the view of the related bean */
        $helper = new MultipleBeanHelper();
        $action = "bind" . ucfirst(strtolower($field));
        $dataItems = [];
        $modelClass = (new \ReflectionClass($this->model))->getShortName();
        $params = [
            'modelClass' => $modelClass,
            'counter'    => $this->templateReplaceKeyword,
            'attribute'  => $this->attribute,
            'min'        => $this->min
        ];
        /* Temlate view that uses for creation of the new bean */
        $template = $helper->{$action}(null, $params);
        /* Fill the available addresses */
        foreach ($currentItems as $key => $item) {
            $params['counter'] = $key;
            $dataItems[] = $helper->{$action}($item, $params);
        }
        /* Fill remaining items to min level */
        for ($i = count($dataItems); $i < $this->min; $i++) {
            $params['counter'] = $i;
            $dataItems[] = $helper->{$action}(null, $params);
        }
        return $this->render($this->viewName, [
            'title'                  => $this->title,
            'dataItems'              => $dataItems,
            'template'               => $template,
            'attribute'              => $this->attribute,
            'templateReplaceKeyword' => $this->templateReplaceKeyword,
            'enableAddOption'        => $this->enableAddOption,
        ]);
    }

    /**
     * Registers the needed assets
     * @return void
     */
    public function registerAssets()
    {
        $view = $this->getView();
        MultipleBeanAsset::register($view);
    }

}
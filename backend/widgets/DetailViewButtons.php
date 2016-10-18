<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/6/16
 * Time: 11:02 AM
 */

namespace backend\widgets;


use yii\jui\Widget;

/**
 * Widget for buttons on detail view like 'Update','Delete','Back to list'
 * @author Artem Kramov
 */
class DetailViewButtons extends Widget
{
    /**
     * Model object for which we generate buttons
     * @var object
     */
    public $model;

    /**
     * @var array
     */
    public $excludeViews = [];

    /**
     * View path
     * @var  string
     */
    private $viewName;

    /**
     * Init view
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->viewName = "detail_view_buttons" . DIRECTORY_SEPARATOR . "view";
    }

    /**
     * @return string
     */
    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        return $this->render($this->viewName, [
            'model'        => $this->model,
            'excludeViews' => $this->excludeViews
        ]);
    }

}
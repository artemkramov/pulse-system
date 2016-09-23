<?php

namespace backend\widgets\related_bean;

use yii\base\Widget;

class RelatedBean extends Widget
{

    public $inputName;

    public $controllerPopup;

    public $controllerView;

    public $label;

    public $labelField;

    public $relatedBean;

    public $options = [];

    /**
     * Registers the needed assets
     * @return void
     */
    public function registerAssets()
    {
        $view = $this->getView();
        RelatedBeanAsset::register($view);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('view', [
            'label'           => $this->label,
            'inputName'       => $this->inputName,
            'controllerPopup' => $this->controllerPopup,
            'controllerView'  => $this->controllerView,
            'labelField'      => $this->labelField,
            'relatedBean'     => $this->relatedBean,
            'options'         => $this->options,
        ]);
    }

}
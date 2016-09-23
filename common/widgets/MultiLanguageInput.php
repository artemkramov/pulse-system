<?php

namespace common\widgets;


use common\models\Bean;
use common\models\Lang;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;

/**
 * Class MultiLanguageInput
 * @package common\widgets
 * @author Artem Kramov
 * Widget for forming of the multilingual input
 */
class MultiLanguageInput extends Widget
{

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var Bean
     */
    public $model;

    /**
     * @var string
     */
    public $field;

    /**
     * @var array
     */
    public $parameters;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    private $viewPath;

    /**
     * Initialize view path
     */
    public function init()
    {
        parent::init();
        $this->viewPath = 'multi-language-input' . DIRECTORY_SEPARATOR . 'view';
    }

    /**
     * @return string
     */
    public function run()
    {
        parent::run();
        $languages = Lang::getLanguages();
        return $this->render($this->viewPath, [
            'form'       => $this->form,
            'model'      => $this->model,
            'field'      => $this->field,
            'parameters' => $this->parameters,
            'languages'  => $languages,
            'title'      => $this->title
        ]);
    }

}
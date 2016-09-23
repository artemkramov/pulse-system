<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/20/2016
 * Time: 10:45 AM
 */

namespace backend\widgets;

use common\models\Bean;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;

/**
 * Class ImageField
 * @package backend\widgets
 */
class ImageField extends Widget
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
    public $fileAttribute;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('image-field/view', [
            'form'          => $this->form,
            'model'         => $this->model,
            'fileAttribute' => $this->fileAttribute,
            'attribute'     => $this->attribute,
        ]);
    }

}
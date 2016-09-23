<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/9/2016
 * Time: 2:30 PM
 */

namespace backend\widgets;


use backend\models\CharacteristicGroup;
use common\models\Bean;
use yii\base\ErrorException;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * Class CharacteristicField
 * @package backend\widgets
 * Widget for the generating of the field for custom product data
 */
class CharacteristicField extends Widget
{

    /**
     * The name of the field
     * @var string
     */
    public $customAttribute;

    /**
     * @var Bean
     */
    public $model;

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var string
     */
    private $viewName;

    /**
     * Init view name
     */
    public function init()
    {
        parent::init();
        $this->viewName = 'characteristic-field/view';
    }

    /**
     * @return string
     * @throws ErrorException
     */
    public function run()
    {
        $group = CharacteristicGroup::find()->where([
            'alias' => $this->customAttribute
        ])->one();
        if (empty($group)) {
            throw new ErrorException('There is no custom attribute with such alias');
        }
        $attributeCollection = $this->model->getCustomAttributesByAlias($this->customAttribute);
        return $this->render($this->viewName, [
            'attributeDropdown' => ArrayHelper::map($attributeCollection, 'id', 'title'),
            'model'             => $this->model,
            'form'              => $this->form,
            'attribute'         => $this->customAttribute,
            'title'             => $group->title
        ]);
    }

}
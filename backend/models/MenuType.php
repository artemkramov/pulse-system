<?php

namespace backend\models;

use common\models\Bean;
use common\modules\i18n\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 */
class MenuType extends Bean
{

    const TYPE_HEADER = 'header';

    const TYPE_FOOTER = 'footer';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'alias'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'slug'      => [
                'class'           => 'common\\behaviors\\Alias',
                'inAttribute'     => 'name',
                'outAttribute'    => 'alias',
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Module::t('Id'),
            'name'  => Module::t('Name'),
            'alias' => Module::t('Alias'),
        ];
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Menu type',
            'multiple' => 'Menu types'
        ];
    }
}

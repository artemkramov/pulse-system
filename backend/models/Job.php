<?php

namespace backend\models;

use common\models\Bean;
use Yii;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $name
 * @property string $method
 */
class Job extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'method'], 'required'],
            [['name', 'method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => 'ID',
            'name'   => 'Name',
            'method' => 'Method',
        ];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/13/2016
 * Time: 9:00 AM
 */

namespace backend\models;


use common\modules\i18n\Module;
use yii\base\Model;

class HeartBeatRange extends Model
{

    public $startTime;

    public $endTime;

    public function rules()
    {
        return [
            [['startTime', 'endTime'], 'required'],
            [['startTime', 'endTime'], 'date', 'format' => 'yyyy-M-d H:m'],
            ['startTime', 'compare', 'compareAttribute' => 'endTime', 'operator' => '<=', 'enableClientValidation' => false]
        ];
    }
     public function attributeLabels()
     {
         return [
             'startTime' => Module::t('Start time'),
             'endTime'   => Module::t('End time'),
         ];
     }

}
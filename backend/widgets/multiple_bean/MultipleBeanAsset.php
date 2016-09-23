<?php

namespace backend\widgets\multiple_bean;

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/31/16
 * Time: 3:03 PM
 */
class MultipleBeanAsset extends \yii\web\AssetBundle
{
    public $sourcePath = "@backend/widgets/multiple_bean/assets";

    public $js = [
        'js/MultipleBean.js',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
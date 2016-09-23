<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/30/2016
 * Time: 5:38 PM
 */

namespace backend\widgets\related_bean;


use yii\web\AssetBundle;

class RelatedBeanAsset extends AssetBundle
{
    public $sourcePath = "@backend/widgets/related_bean/assets";

    public $js = [
        'js/RelatedBean.js',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
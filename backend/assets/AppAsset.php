<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jqtree/jqtree.css',
        'css/fancybox/jquery.fancybox.css',
        'css/bonsai/jquery.bonsai.css',
        'css/chosen/chosen.css',
        'http://vjs.zencdn.net/5.10.8/video-js.css',
        'css/site.css',
        'css/awesome-bootstrap-checkbox.css',
    ];
    public $js = [
        'js/chosen.jquery.js',
        'js/jqtree/tree.jquery.js',
        'js/fancybox/jquery.fancybox.pack.js',
        'js/bonsai/jquery.qubit.js',
        'js/bonsai/jquery.bonsai.js',
        'js/turn/turn.min.js',
        'http://vjs.zencdn.net/5.10.8/video.js',
        'js/App.js',
        'js/Template.js',
        'js/Product.js',
        'js/Report.js',
        'js/Role.js',
        'js/RelatedBean.js',
        'js/Sale.js',
        'js/chosen/chosen.jquery.min.js',
        '//cdn.tinymce.com/4/tinymce.min.js',
        'js/filemanager.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

<?php

/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/16/16
 * Time: 12:05 PM
 */

namespace backend\widgets;

use common\models\Lang;
use yii\bootstrap\Widget;

/**
 * Language switcher on the site
 * @author Artem Kramov
 */
class WLang extends Widget
{
    /**
     * Path to widget view
     * @var string
     */
    private $viewName;

    public function init()
    {
        $this->viewName = 'lang' . DIRECTORY_SEPARATOR . 'view';
    }

    public function run()
    {
        return $this->render($this->viewName, [
            'current' => Lang::getCurrent(),
            'langs'   => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all()
        ]);
    }

}
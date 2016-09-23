<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/6/2016
 * Time: 4:45 PM
 */

namespace frontend\widgets;


use common\models\Lang;
use yii\base\Widget;

/**
 * Class LangSwitcherWidget
 * @package frontend\widgets
 */
class LangSwitcherWidget extends Widget
{
    /**
     * @var string
     */
    private $viewName;

    /**
     * Init view name
     */
    public function init()
    {
        $this->viewName = 'lang-switcher' . DIRECTORY_SEPARATOR . 'view';
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->viewName, [
            'current'   => Lang::getCurrent(),
            'languages' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all()
        ]);
    }

}
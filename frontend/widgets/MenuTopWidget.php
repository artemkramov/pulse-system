<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/6/2016
 * Time: 4:11 PM
 */

namespace frontend\widgets;


use backend\components\SiteHelper;
use backend\models\Category;
use backend\models\Characteristic;
use backend\models\MenuType;
use backend\models\Product;
use common\models\Lang;
use common\models\Menu;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class MenuTopWidget
 * @package frontend\widgets
 * Widget for the building of the top menu
 */
class MenuTopWidget extends Widget
{

    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var array
     */
    private $callbackMenu = [
    ];

    /**
     * Init view path
     */
    public function init()
    {
        $this->viewPath = 'menu-top' . DIRECTORY_SEPARATOR . 'view';
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        /**
         * @var MenuType $menuTopType
         */
        $menuTopType = MenuType::find()->where([
            'alias' => MenuType::TYPE_HEADER
        ])->one();
        $menuCollection = Menu::findAllWithTitle(null, $menuTopType->id);
        $menuTree = SiteHelper::buildTreeArrayFromCollection($menuCollection, 'id');
        foreach ($menuTree as $key => $menuRoot) {
            if (array_key_exists($menuRoot['id'], $this->callbackMenu)) {
                $methodName = $this->callbackMenu[$menuRoot['id']];
                if (method_exists($this, $methodName)) {
                    $menuTree[$key] = $this->{$methodName}($menuRoot);
                }
            }
        }
        return $this->render($this->viewPath, [
            'menuCollection' => $menuTree
        ]);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/13/2016
 * Time: 4:44 PM
 */

namespace frontend\widgets;

use backend\components\SiteHelper;
use backend\models\MenuType;
use common\models\Menu;
use yii\base\Widget;

/**
 * Class MenuFooterWidget
 * @package frontend\widgets
 */
class MenuFooterWidget extends Widget
{

    /**
     * @var string
     */
    private $viewPath;

    /**
     * Init view path
     */
    public function init()
    {
        $this->viewPath = 'menu-footer' . DIRECTORY_SEPARATOR . 'view';
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        $menuTopType = MenuType::find()->where([
            'alias' => MenuType::TYPE_FOOTER
        ])->one();
        $menuCollection = Menu::findAllWithTitle(null, $menuTopType->id);
        $menuTree = SiteHelper::buildTreeArrayFromCollection($menuCollection, 'id');
        return $this->render($this->viewPath, [
            'menuCollection' => $menuTree
        ]);
    }

}
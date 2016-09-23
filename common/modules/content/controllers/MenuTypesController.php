<?php

namespace common\modules\content\controllers;

use backend\controllers\CRUDController;
use backend\models\MenuType;
use backend\models\search\MenuTypeSearch;
use common\models\Menu;
use common\modules\i18n\Module;

/**
 * MenuTypesController implements the CRUD actions for MenuType model.
 */
class MenuTypesController extends CRUDController
{

    /**
     * Init bean class
     */
    public function init()
    {
        $this->beanClass = MenuType::className();
        $this->beanSearchClass = MenuTypeSearch::className();
        parent::init();
    }

    /**
     * Sort and position action for menu
     * @param $id
     * @return string
     */
    public function actionSort($id)
    {
        $menuType = $this->findModel($id);
        if (\Yii::$app->request->post()) {
            $jsonTree = \Yii::$app->request->post('jsonTree');
            if (!empty($jsonTree)) {
                Menu::saveMenuTree($jsonTree);
                \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
                return $this->redirect(['sort', 'id' => $id]);
            }
        }
        return $this->render('sort', [
            'menuType' => $menuType
        ]);
    }

}

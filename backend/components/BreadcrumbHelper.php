<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/6/16
 * Time: 12:42 PM
 */

namespace backend\components;


use common\modules\i18n\Module;
use yii\base\Exception;

/**
 * Helper for building of the CRUD breadcrumbs
 * Called in views
 * @author Artem Kramov
 */
class BreadcrumbHelper
{

    /**
     * Method which sets title and breadcrumbs
     * For the CRUD purpose
     * @param object $viewData
     * @param array $extraData
     * @param null $model
     * @throws Exception
     */
    public static function set($viewData, $extraData, $model = null)
    {
        if (!array_key_exists('type', $extraData)) {
            throw new Exception("Please provide the type of the breadcrumb");
        }
        $actionName = "handle" . ucfirst($extraData['type']);
        if (!method_exists(__CLASS__, $actionName)) {
            throw new Exception("No such method {$actionName} in the helper");
        }
        self::$actionName($viewData, $extraData, $model);
    }

    /**
     * Set title and breadcrumb for the list
     * @param object $viewData
     * @param array $extraData
     * @param $model
     */
    public function handleIndex($viewData, $extraData, $model)
    {
        $viewData->title = Module::t($extraData['multiple']);
        $viewData->params['breadcrumbs'][] = $viewData->title;
    }

    /**
     * Set title and breadcrumb for the sort view
     * @param $viewData
     * @param $extraData
     * @param $model
     */
    public function handleSort($viewData, $extraData, $model)
    {
        $viewData->title = Module::t('Sort action') . ': ' . Module::t($extraData['multiple']);
        $viewData->params['breadcrumbs'][] = ['label' => Module::t($extraData['multiple']), 'url' => ['index']];
        $viewData->params['breadcrumbs'][] = $viewData->title;
    }

    /**
     * Set title and breadcrumb for the create view
     * @param object $viewData
     * @param array $extraData
     * @param object $model
     */
    public function handleCreate($viewData, $extraData, $model)
    {
        $viewData->title = Module::t('Create') . ' ' . Module::t($extraData['singular']);
        $viewData->params['breadcrumbs'][] = ['label' => Module::t($extraData['multiple']), 'url' => ['index']];
        $viewData->params['breadcrumbs'][] = $viewData->title;
    }

    /**
     * Set title and breadcrumb for the update view
     * @param object $viewData
     * @param array $extraData
     * @param object $model
     */
    public function handleUpdate($viewData, $extraData, $model)
    {
        $field = self::getField($extraData);
        $viewData->title = Module::t('Update') . ' ' . Module::t($extraData['singular']) . ': ';
        if (array_key_exists('customTitle', $extraData)) {
            $subTitle = $extraData['customTitle'];
        }
        else {
            $subTitle = $model->{$field};
        }
        $viewData->title .= $subTitle;
        if (SiteHelper::checkActionPermission(['index'])) {
            $viewData->params['breadcrumbs'][] = ['label' => Module::t($extraData['multiple']), 'url' => ['index']];
        }
        if (SiteHelper::checkActionPermission(['view'])) {
            $viewData->params['breadcrumbs'][] = ['label' => $subTitle, 'url' => ['view', 'id' => $model->id]];
        }
        $viewData->params['breadcrumbs'][] = Module::t('Update');
    }

    /**
     * Returns field for title and breadcrumb purpose
     * @param array $extraData
     * @return string
     */
    private static function getField($extraData)
    {
        $field = "name";
        if (array_key_exists('field', $extraData)) {
            $field = $extraData['field'];
        }
        return $field;
    }

    /**
     * Set title and breadcrumb for the view page
     * @param object $viewData
     * @param array $extraData
     * @param object $model
     */
    public function handleView($viewData, $extraData, $model)
    {
        $field = self::getField($extraData);
        if (array_key_exists('customTitle', $extraData)) {
            $title = $extraData['customTitle'];
        }
        else {
            $title = $model->{$field};
        }
        $viewData->title = $title;
        if (SiteHelper::checkActionPermission(['index'])) {
            $viewData->params['breadcrumbs'][] = ['label' => Module::t($extraData['multiple']), 'url' => ['index']];
        }

        $viewData->params['breadcrumbs'][] = $title;
    }


}
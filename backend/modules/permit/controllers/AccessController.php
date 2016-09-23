<?php

namespace backend\modules\permit\controllers;

use backend\components\SiteHelper;
use backend\controllers\CRUDController;
use common\modules\i18n\Module;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\validators\RegularExpressionValidator;
use yii\web\Controller;
use Yii;

/**
 * Class for RBAC management (both permissions and roles)
 * Rewrited from https://github.com/developeruz/yii2-db-rbac
 * */
class AccessController extends CRUDController
{

    const TABLE_AUTH_ITEM = 'auth_item';

    const TYPE_PERMISSION = 2;

    /** @var string */
    protected $error;

    /** @var string */
    protected $pattern4Role = '/^[a-zA-Z0-9_-]+$/';

    /** @var string */
    protected $pattern4Permission = '/^[a-zA-Z0-9_\/-]+$/';

    /**
     * @return string
     */
    public function actionRole()
    {
        return $this->render('role');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreateRole()
    {
        if (Yii::$app->request->post('name')
            && $this->validate(Yii::$app->request->post('name'), $this->pattern4Role)
            && $this->isUnique(Yii::$app->request->post('name'), 'role')
        ) {
            $role = Yii::$app->authManager->createRole(Yii::$app->request->post('name'));
            $role->description = Yii::$app->request->post('description');
            Yii::$app->authManager->add($role);
            $this->setPermissions(Yii::$app->request->post('permissions', []), $role);
            \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
            return $this->redirect(Url::toRoute([
                'update-role',
                'name' => $role->name,
                'role' => $role
            ]));
        }

        $permissions = ArrayHelper::map(Yii::$app->authManager->getPermissions(), 'name', 'description');
        $permissions = SiteHelper::buildTreeArray($this->getPermissions(), 'name');
        return $this->render(
            '_form_role',
            [
                'permissions' => $permissions,
                'error'       => $this->error,
                'role'        => new Role(),
                'role_permit' => []
            ]
        );
    }

    /**
     * @param $field
     * @param $regex
     * @return bool
     */
    protected function validate($field, $regex)
    {
        $validator = new RegularExpressionValidator(['pattern' => $regex]);
        if ($validator->validate($field, $error))
            return true;
        else {
            $this->error[] = Yii::t('db_rbac', 'Значение "{field}" содержит не допустимые символы', ['field' => $field]);
            return false;
        }
    }

    /**
     * @param $name
     * @param $type
     * @return bool
     */
    protected function isUnique($name, $type)
    {
        if ($type == 'role') {
            $role = Yii::$app->authManager->getRole($name);
            if ($role instanceof Role) {
                $this->error[] = Module::t('Role with such name already exists: ') . $name;
                return false;
            } else return true;
        } elseif ($type == 'permission') {
            $permission = Yii::$app->authManager->getPermission($name);
            if ($permission instanceof Permission) {
                $this->error[] = Module::t('Rule with such name already exists: ') . $name;
                return false;
            } else return true;
        }
    }

    /**
     * @param $permissions
     * @param $role
     */
    protected function setPermissions($permissions, $role)
    {
        foreach ($permissions as $permit) {
            $new_permit = Yii::$app->authManager->getPermission($permit);
            Yii::$app->authManager->addChild($role, $new_permit);
        }
    }

    /**
     * @return array
     */
    private function getPermissions()
    {
        return (new Query())
            ->select('*')
            ->from(self::TABLE_AUTH_ITEM)
            ->where(['type' => self::TYPE_PERMISSION])
            ->all();
    }

    /**
     * @param $name
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionUpdateRole($name)
    {
        $role = Yii::$app->authManager->getRole($name);

        $permissions = ArrayHelper::map(Yii::$app->authManager->getPermissions(), 'name', 'description');
        $role_permit = array_keys(Yii::$app->authManager->getPermissionsByRole($name));
        $permissions = SiteHelper::buildTreeArray($this->getPermissions(), 'name');

        if ($role instanceof Role) {
            if (Yii::$app->request->post('name')
                && $this->validate(Yii::$app->request->post('name'), $this->pattern4Role)
            ) {
                if (Yii::$app->request->post('name') != $name && !$this->isUnique(Yii::$app->request->post('name'), 'role')) {
                    return $this->render(
                        '_form_role',
                        [
                            'role'        => $role,
                            'permissions' => $permissions,
                            'role_permit' => $role_permit,
                            'error'       => $this->error
                        ]
                    );
                }
                $role = $this->setAttribute($role, Yii::$app->request->post());
                Yii::$app->authManager->update($name, $role);
                Yii::$app->authManager->removeChildren($role);
                $this->setPermissions(Yii::$app->request->post('permissions', []), $role);
                \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
                return $this->redirect(Url::toRoute([
                    'update-role',
                    'name' => $role->name
                ]));
            }

            return $this->render(
                '_form_role',
                [
                    'role'        => $role,
                    'permissions' => $permissions,
                    'role_permit' => $role_permit,
                    'error'       => $this->error
                ]
            );
        } else {
            throw new BadRequestHttpException(Yii::t('db_rbac', 'Страница не найдена'));
        }
    }

    /**
     * @param $object
     * @param $data
     * @return mixed
     */
    protected function setAttribute($object, $data)
    {
        $object->name = $data['name'];
        $object->description = $data['description'];
        return $object;
    }

    /**
     * @param $name
     * @return \yii\web\Response
     */
    public function actionDeleteRole($name)
    {
        $role = Yii::$app->authManager->getRole($name);
        if ($role) {
            Yii::$app->authManager->removeChildren($role);
            Yii::$app->authManager->remove($role);
        }
        return $this->redirect(Url::toRoute(['role']));
    }

    /**
     * @return string
     */
    public function actionPermission()
    {
        return $this->render('permission');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreatePermission()
    {
        $permission = $this->clear(Yii::$app->request->post('name'));
        if ($permission
            && $this->validate($permission, $this->pattern4Permission)
            && $this->isUnique($permission, 'permission')
        ) {
            $permit = Yii::$app->authManager->createPermission($permission);
            $permit->description = Yii::$app->request->post('description', '');
            Yii::$app->authManager->add($permit);
            $this->updatePermissionParent($permit->name, \Yii::$app->request->post('parent_id'));
            \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
            return $this->redirect(Url::toRoute([
                'update-permission',
                'name' => $permit->name
            ]));
        }
        $extraData = $this->getPermissionData('');
        $permissionsTree = SiteHelper::buildTreeArray($this->getPermissions(), 'name');
        $permissionsDropdown = SiteHelper::buildTreeDropdown($permissionsTree, 'name', 'description');
        return $this->render('_form_permission', [
            'error'       => $this->error,
            'permit'      => new Permission(),
            'permissions' => $permissionsDropdown,
            'extraData'   => $extraData
        ]);
    }

    /**
     * @param $value
     * @return string
     */
    protected function clear($value)
    {
        if (!empty($value)) {
            $value = trim($value, "/ \t\n\r\0\x0B");
        }
        return $value;
    }

    /**
     * @param $permissionName
     * @param $parent
     * @throws \yii\db\Exception
     */
    private function updatePermissionParent($permissionName, $parent)
    {
        $sql = "UPDATE " . self::TABLE_AUTH_ITEM . " SET parent_id=:parent_id WHERE name=:name";
        Yii::$app->db->createCommand($sql)
            ->bindValue(':parent_id', $parent)
            ->bindValue(':name', $permissionName)
            ->execute();
    }

    /**
     * @param $permissionName
     * @return array|bool
     */
    private function getPermissionData($permissionName)
    {
        $data = (new Query())
            ->select('*')
            ->from(self::TABLE_AUTH_ITEM)
            ->where(['name' => $permissionName])
            ->one();
        if (empty($data)) $data = [];
        return $data;
    }

    /**
     * @param $name
     * @return \yii\web\Response
     */
    public function actionDeletePermission($name)
    {
        $permit = Yii::$app->authManager->getPermission($name);
        if ($permit)
            Yii::$app->authManager->remove($permit);
        return $this->redirect(Url::toRoute(['permission']));
    }

    /**
     * @param $name
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionUpdatePermission($name)
    {
        $permit = Yii::$app->authManager->getPermission($name);
        $permissionsTree = SiteHelper::buildTreeArray($this->getPermissions(), 'name');
        $permissionsDropdown = SiteHelper::buildTreeDropdown($permissionsTree, 'name', 'description');
        if ($permit instanceof Permission) {
            $permission = $this->clear(Yii::$app->request->post('name'));
            if ($permission && $this->validate($permission, $this->pattern4Permission)
            ) {
                if ($permission != $name && !$this->isUnique($permission, 'permission')) {
                    return $this->render('_form_permission', [
                        'permit'      => $permit,
                        'error'       => $this->error,
                        'permissions' => $permissionsDropdown,
                        'extraData'   => $this->getPermissionData($permit->name)
                    ]);
                }

                $permit->name = $permission;
                $permit->description = Yii::$app->request->post('description', '');
                Yii::$app->authManager->update($name, $permit);
                $this->updatePermissionParent($name, \Yii::$app->request->post('parent_id'));
                \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
                return $this->redirect(Url::toRoute([
                    'update-permission',
                    'name' => $permit->name
                ]));
            }

            return $this->render('_form_permission', [
                'permit'      => $permit,
                'error'       => $this->error,
                'permissions' => $permissionsDropdown,
                'extraData'   => $this->getPermissionData($permit->name)
            ]);
        } else throw new BadRequestHttpException(Yii::t('db_rbac', 'Страница не найдена'));
    }

}
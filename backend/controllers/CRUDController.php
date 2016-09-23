<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/26/16
 * Time: 3:01 PM
 */

namespace backend\controllers;

use backend\components\AccessHelper;
use common\models\User;
use common\modules\i18n\Module;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CRUD controller is used to make create, read, update and delete operations
 * with given model. Maybe some common action for models can be added here
 * @author Artem Kramov
 * */
class CRUDController extends AuthController
{

    /**
     * Init data
     */
    public function init()
    {
        $this->enableCsrfValidation = false;
        parent::init();
    }

    const MASSUPDATE_FIELD = "selection";
    const MASSUPDATE_BEAN = "bean";

    /**
     * Class of the model with which we work
     * @var string $beanClass
     */
    protected $beanClass;

    /**
     * Class of the search model
     * @var string $beanSearchClass
     */
    protected $beanSearchClass;

    /**
     * Related views of the model
     * @var array $views
     */
    protected $views = [
        'create' => 'create',
        'index'  => '',
        'update' => 'update'
    ];

    protected $extraAccessParams = [];

    /**
     * Behaviour for access checking to the special route
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs'             => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'as AccessBehavior' => [
                'class' => \app\rbac\AccessBehavior::className(),
            ]
        ]);
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchClass = $this->beanSearchClass;
        $searchModel = new $searchClass();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all models in popup.
     * @param string $openerID
     * @param string $labelField
     * @return mixed
     */
    public function actionPopup($openerID, $labelField)
    {
        $searchClass = $this->beanSearchClass;
        $searchModel = new $searchClass();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('popup', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'openerID'     => $openerID,
            'labelField'   => $labelField,
        ]);
    }

    /**
     * Create action
     * @param array $extraParams
     * @return string|\yii\web\Response
     */
    public function actionCreate($extraParams = [])
    {
        $className = $this->beanClass;
        $model = new $className();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([AccessHelper::formPrimaryUrl('view'), 'id' => $model->id]);
        } else {
            if (!empty($model->errors)) {
                $error = [];
                foreach ($model->errors as $errorArray) {
                    $error = ArrayHelper::merge($error, $errorArray);
                }
                $errorString = implode('<br/>', $error);
                \Yii::$app->session->setFlash('error', $errorString);
            }
            return $this->render('create', ArrayHelper::merge([
                'model' => $model,
            ], $extraParams));
        }
    }

    /**
     * Get model for viewing with access checking
     * @param int $id
     * @param boolean $returnModel
     * @param array $extraParams
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionView($id, $returnModel = false, $extraParams = [])
    {
        $model = $this->getModel($id);
        if ($returnModel) {
            return $model;
        }
        return $this->render('view', ArrayHelper::merge([
            'model' => $model,
        ], $extraParams));
    }

    /**
     * Getting model with access checking
     * and checking if the record exists in DB
     * @param $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function getModel($id)
    {
        $model = $this->findModel($id);
        $path = \Yii::$app->urlManager->parseRequest(\Yii::$app->request);
        if (!User::isAdmin() && !\Yii::$app->user->can($path[0], ['bean' => $model, 'check' => true, 'extraAccessParams' => $this->extraAccessParams])) {
            throw new ForbiddenHttpException();
        }
        return $model;
    }

    /**
     * Return model by ID. Throws exception in the case the model wasn't found
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $className = $this->beanClass;
        $bean = new $className();
        $query = $className::find()->where(['id' => $id]);
        if (!empty($bean->getMultiLanguageFields())) {
            $query = $query->multilingual();
        }
        if (($model = $query->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Get model for updating with access checking
     * @param $id
     * @param bool $returnModel
     * @param array $extraParams
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id, $returnModel = false, $extraParams = [])
    {
        if ($returnModel) {
            return $this->getModel($id);
        }
        $model = $this->getModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([AccessHelper::formPrimaryUrl('view'), 'id' => $model->id]);
        } else {
            if (!empty($model->errors)) {
                $error = [];
                foreach ($model->errors as $errorArray) {
                    $error = ArrayHelper::merge($error, $errorArray);
                }
                $errorString = implode('<br/>', $error);
                \Yii::$app->session->setFlash('error', $errorString);
            }
            return $this->render('update', ArrayHelper::merge([
                'model' => $model,
            ], $extraParams));
        }
    }

    /**
     * Get model for deleting with access checking
     * @param $id
     * @param bool $returnModel
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id, $returnModel = false)
    {
        if ($returnModel) {
            return $this->getModel($id);
        }
        $this->findModel($id)->delete();
        return $this->redirect(AccessHelper::formPrimaryUrl('index'));
    }

    /**
     * Method for massive update of the bean
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionMassUpdate()
    {
        $postData = \Yii::$app->request->post();
        $massupdateField = self::MASSUPDATE_FIELD;
        $error = "";
        if (!array_key_exists($massupdateField, $postData)) {
            $error = Module::t('Choose at least one item');
        }
        if (!empty($error)) {
            \Yii::$app->session->setFlash('error', $error);
        } else {
            $selectedItems = $postData[$massupdateField];
            $fields = $postData['Massupdate'];
            foreach ($selectedItems as $beanID) {
                $bean = $this->getModel($beanID);
                foreach ($fields as $fieldName => $fieldValue) {
                    $bean->$fieldName = $fieldValue;
                    $bean->save();
                }
            }
        }
        if (empty($error)) {
            \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Sort and position action for menu
     * @return string
     */
    public function actionSort()
    {
        if (\Yii::$app->request->post()) {
            $jsonTree = \Yii::$app->request->post('jsonTree');
            if (!empty($jsonTree)) {
                $beanClass = $this->beanClass;
                $beanClass::saveSortPositions($jsonTree);
                \Yii::$app->session->setFlash('success', Module::t('Operation is done successfully.'));
                return $this->redirect(['sort']);
            }
        }
        return $this->render('sort');
    }

    /**
     * Ajax validation of the Bean
     * Return JSON Response
     * @param null $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionValidate($id = null)
    {
        $beanClass = $this->beanClass;
        $model = new $beanClass();
        if (isset($id)) {
            $model = $this->findModel($id);
        }
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $errors = ActiveForm::validate($model);
            return $errors;
        }
    }


}
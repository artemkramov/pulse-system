<?php
namespace backend\controllers;

use backend\components\MultipleBeanHelper;
use backend\components\SiteHelper;
use backend\models\Category;
use backend\models\Characteristic;
use backend\models\Product;
use backend\models\SocialLink;
use backend\models\Stock;
use common\models\HeartBeat;
use common\models\Lang;
use common\models\Menu;
use common\models\SaleProduct;
use common\models\search\Customer;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\base\ViewContextInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;


/**
 * Site controller
 */
class AjaxController extends AuthController implements ViewContextInterface
{
    /**
     * @inheritdoc
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
            'contentNegotiator' => [
                'class'   => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function actionLoadMenuItems($id)
    {
        $menuCollection = Menu::findAllWithTitle(null, $id);
        $menuTree = SiteHelper::buildTreeArrayFromCollection($menuCollection, 'id', 'title');
        return $menuTree;
    }

    /**
     * @param null $menuTypeID
     * @return array
     */
    public function actionLoadMenuDropdown($menuTypeID = null)
    {
        $menuList = Menu::getMenuDropdown(-1, $menuTypeID);
        $response = [];
        foreach ($menuList as $id => $name) {
            $response[] = [
                'id'   => $id,
                'name' => $name
            ];
        }
        return $response;
    }

    /**
     * @param $beatID
     * @param $ibi
     * @return array
     */
    public function actionPushIbiData($beatID, $ibi)
    {
        /**
         * @var HeartBeat $heartBeat
         */
        $heartBeat = HeartBeat::findOne($beatID);
        $heartBeat->ibi = $ibi;
        $heartBeat->save();
        return [];
    }

    /**
     * @param $customerID
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function actionLoadGraphData($customerID, $startTime, $endTime)
    {
        /**
         * @var Customer $customer
         */
        $customer = Customer::findOne($customerID);
        $dataPoints = $customer->getGraphData($startTime, $endTime);
        return $dataPoints;
    }


}
 

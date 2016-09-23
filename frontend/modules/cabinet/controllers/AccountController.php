<?php

namespace frontend\modules\cabinet\controllers;


use backend\models\Product;
use common\models\Address;
use common\models\Order;
use common\models\User;
use common\modules\i18n\Module;
use frontend\controllers\AuthController;
use frontend\models\OrderFilter;
use frontend\models\ProductForm;
use frontend\models\Profile;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AccountController
 * @package frontend\modules\cabinet\controllers
 */
class AccountController extends AuthController
{
    /**
     * @var User
     */
    private $user;

    /**
     * Init default parameters
     */
    public function init()
    {
        \Yii::$app->params['template'] = 'content-cabinet';
        $this->user = \Yii::$app->user->identity;
        parent::init();
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'user' => $this->user
        ]);
    }

    /**
     * @return string
     */
    public function actionProfile()
    {
        $profile = new Profile();
        $profile->loadUserData();
        $profile->load(\Yii::$app->request->get());
        if ($profile->load(\Yii::$app->request->post()) && $profile->validate()) {
            $profile->save();
            \Yii::$app->session->setFlash('success', Module::t('Profile is updated successfully.'));
            return $this->redirect(Url::canonical());
        }
        return $this->render('profile', [
            'model' => $profile
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddress()
    {
        $address = Address::find()
            ->where([
                'user_id' => $this->user->id,
            ])
            ->one();
        if (empty($address)) {
            $address = new Address();
        }
        if ($address->load(\Yii::$app->request->post()) && $address->validate()) {
            $address->user_id = $this->user->id;
            if ($address->save()) {
                \Yii::$app->session->setFlash('success', Module::t('Address is updated successfully.'));
            }
            return $this->redirect(Url::canonical());
        }
        return $this->render('address', [
            'model' => $address
        ]);
    }

    public function actionOrders()
    {
        $searchModel = new OrderFilter();
        $dataProvider = $searchModel->search([]);
        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionOrderView($id)
    {
        $order = Order::findOne($id);
        if (empty($order)) {
            throw new NotFoundHttpException();
        }
        return $this->render('order-view', [
            'order' => $order
        ]);
    }

    /**
     * @return string
     */
    public function actionFavourite()
    {
        $products = $this->user->getFavouriteProducts();
        return $this->render('favourite', [
            'products' => $products
        ]);
    }

    /**
     * @return array
     */
    public function actionAddToFavourite()
    {
        $postData = \Yii::$app->request->post();
        if (!empty($postData) && array_key_exists('productID', $postData)) {
            /**
             * @var Product $product
             */
            $product = Product::getProductByID($postData['productID']);
            $response = [];
            if (!empty($product)) {
                $response = $product->addToFavourite();
            }
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }
    }

    /**
     * @param $productID
     * @return Response
     */
    public function actionRemoveFromFavourite($productID)
    {
        if (!empty($productID)) {
            /**
             * @var Product $product
             */
            $product = Product::getProductByID($productID);
            $response = $product->removeFromFavourite();
            if ($response['success']) {
                \Yii::$app->session->setFlash('success', Module::t('The product was removed from the wish list'));
                return $this->redirect('favourite');
            }
        }
    }

}
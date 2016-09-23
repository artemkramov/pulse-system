<?php
namespace backend\controllers;

use backend\components\MultipleBeanHelper;
use backend\components\SiteHelper;
use backend\models\Category;
use backend\models\Characteristic;
use backend\models\Product;
use backend\models\SocialLink;
use backend\models\Stock;
use common\models\Lang;
use common\models\Menu;
use common\models\SaleProduct;
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
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionLoadSocialLinks()
    {
        $items = SocialLink::find()->orderBy('sort')->all();
        return $items;
    }

    /**
     * @return array
     */
    public function actionLoadStocks()
    {
        $stocks = Stock::find()->localized(Lang::getCurrent()->url)->orderBy('sort')->all();
        $response = [];
        foreach ($stocks as $stock) {
            $attributeData = $stock->attributes;
            $attributeData['name'] = $stock->title;
            $response[] = $attributeData;
        }
        return $response;
    }

    /**
     * @param integer $id - ID of the characteristic group
     * @return array
     */
    public function actionLoadCharacteristics($id)
    {
        $items = Characteristic::find()->localized(Lang::getCurrent()->url)->where([
            'characteristic_group_id' => $id
        ])->orderBy('sort')->all();
        $response = [];
        foreach ($items as $item) {
            $attributeData = $item->attributes;
            $attributeData['name'] = $item->title;
            $response[] = $attributeData;
        }
        return $response;
    }

    /**
     * @return array
     */
    public function actionLoadCategories()
    {
        $collection = Category::findAllWithTitle(null);
        $tree = SiteHelper::buildTreeArrayFromCollection($collection, 'id', 'title');
        return $tree;
    }

    /**
     * @param $id
     * @return Product
     */
    public function actionLoadProductData($id)
    {
        $product = Product::findOne($id);
        if (empty($product)) {
            $product = new Product();
        }
        $productData = $product->attributes;
        $productData['title'] = $product->title;
        $productData['url'] = !empty($product->id) ? Url::to(['products/products/view', 'id' => $product->id]) : '#';
        return $productData;
    }

    public function actionLoadCollectionProducts($collectionID)
    {
        $products = Product::getProductsByCollection($collectionID);
        $html = "";
        $this->viewPath = \Yii::getAlias('@backend/modules/products/views/sale-products');
        $attributes = (new SaleProduct())->getAttributes();
        $attributesData = [];
        $params = [
            'modelClass' => 'Sale',
            'counter'    => '{{template_replace_keyword}}',
            'attribute'  => 'saleProducts',
            'min'        => 1,
        ];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => MultipleBeanHelper::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => MultipleBeanHelper::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        foreach ($products as $product) {
            $html .= $this->renderPartial('view', ArrayHelper::merge([
                'model'          => null,
                'attributesData' => $attributesData,
                'product'        => $product,
            ], $params));
        }
        return [
            'data' => $html,
        ];

    }


}
 

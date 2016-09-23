<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 5/31/16
 * Time: 1:45 PM
 */

namespace backend\components;


use backend\models\Characteristic;
use backend\models\CharacteristicGroup;
use backend\models\Currency;
use backend\models\KitProduct;
use backend\models\Product;
use backend\models\ProductGallery;
use backend\models\ProductVariation;
use backend\models\SliderItem;
use common\models\Address;
use common\models\Country;
use common\models\MagazineItem;
use common\models\OrderItem;
use common\models\SaleProduct;
use yii\helpers\ArrayHelper;

/**
 * Class for handling of the one-to-many entities (like multiple addresses to one user e.t.c)
 * */
class MultipleBeanHelper
{

    /**
     * Generate address form view
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindAddress($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new Address();
        }
        $countries = Country::getDropdownList();
        $viewPath = "@backend/modules/products/views/address/view";
        $attributes = (new Address())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'countries'      => $countries,
            'attributesData' => $attributesData
        ], $params));
    }

    /**
     * Generate ID attribute for a field based on it's name and counter
     * @param $field
     * @param $attribute
     * @param $modelClass
     * @param $counter
     * @return string
     */
    public static function formIdAttribute($field, $attribute, $modelClass, $counter)
    {
        $data = array(
            $modelClass, $attribute, $field, $counter
        );
        return strtolower(implode("-", $data));
    }

    /**
     * Generate name for field
     * @param $field
     * @param $attribute
     * @param $modelClass
     * @param $counter
     * @return string
     */
    public static function formName($field, $attribute, $modelClass, $counter)
    {
        return $modelClass . "[" . $attribute . "][" . $field . "][" . $counter . "]";
    }

    /**
     * Generate images for slider
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindSlideritems($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new SliderItem();
        }
        $viewPath = "@common/modules/content/views/slider-items/view";
        $attributes = (new SliderItem())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
        ], $params));
    }

    /**
     * Generate product price variations
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindVariations($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new ProductVariation();
        }
        $viewPath = "@backend/modules/products/views/variations/view";
        $attributes = (new ProductVariation())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        $sizeGroup = CharacteristicGroup::find()->where(['alias' => 'size'])->one();
        $sizes = ArrayHelper::map((new Product())->getCustomAttributesByAlias('size'), 'id', 'title');
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
            'sizes'          => $sizes,
            'group'          => $sizeGroup,
            'currencies'     => Currency::listAll()
        ], $params));
    }

    /**
     * Generate images for the product
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindImages($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new ProductGallery();
        }
        $viewPath = "@backend/modules/products/views/images/view";
        $attributes = (new ProductGallery())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
        ], $params));
    }

    /**
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindItems($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new KitProduct();
        }
        $viewPath = "@backend/modules/products/views/kit-products/view";
        $attributes = (new KitProduct())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
        ], $params));
    }

    /**
     * Generate order item form view
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindOrderitems($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new OrderItem();
        }
        $viewPath = "@backend/modules/products/views/order-item/view";
        $attributes = (new OrderItem())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        return \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData
        ], $params));
    }

    /**
     * Generate sale products form view
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindSaleproducts($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new SaleProduct();
        }
        $viewPath = "@backend/modules/products/views/sale-products/view";
        $attributes = (new SaleProduct())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        $html = \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
            'product'        => null,
        ], $params));
        return preg_replace('~>\s+<~', '><', $html);
    }

    /**
     * Generate sale products form view
     * @param null $model
     * @param array $params
     * @return string
     */
    public function bindMagazineitems($model = null, $params = [])
    {
        if (!isset($model)) {
            $model = new MagazineItem();
        }
        $viewPath = "@common/modules/content/views/magazine-items/view";
        $attributes = (new MagazineItem())->getAttributes();
        $attributesData = [];
        foreach ($attributes as $attribute => $value) {
            $attributesData[$attribute] = [
                'id'   => self::formIdAttribute($attribute, $params['attribute'], $params['modelClass'], $params['counter']),
                'name' => self::formName($attribute, $params['attribute'], $params['modelClass'], $params['counter'])
            ];
        }
        $html = \Yii::$app->controller->renderPartial($viewPath, ArrayHelper::merge([
            'model'          => $model,
            'attributesData' => $attributesData,
        ], $params));
        return preg_replace('~>\s+<~', '><', $html);
    }


}
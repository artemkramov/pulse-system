<?php

namespace backend\models;

use backend\components\SiteHelper;
use common\models\Bean;
use common\modules\i18n\Module;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 *
 * @property SliderItem[] $sliderItems
 */
class Slider extends Bean
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name', 'alias'], 'string', 'max' => 255],
            ['sliderItems', 'validateRelatedBeans', 'skipOnEmpty' => false, 'skipOnError' => false, 'params' => ['beanRelatedField' => 'slider_id', 'beanClass' => SliderItem::className()]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Module::t('Id'),
            'name'  => Module::t('Name'),
            'alias' => Module::t('Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderItems()
    {
        return $this->hasMany(SliderItem::className(), ['slider_id' => 'id'])->orderBy('sort');
    }

    /**
     * Method for getting the name of the bean
     * Is called for breadcrumb generation
     * @return array
     */
    public static function getLabels()
    {
        return [
            'singular' => 'Slider',
            'multiple' => 'Sliders'
        ];
    }

    /**
     * @param array $postData
     * @return array
     */
    public function setSliderItems($postData)
    {
        SliderItem::deleteAll(['slider_id' => $this->id]);
        $files = UploadedFile::getInstancesByName('file');
        $uploadFolder = self::getUploadFolder();
        $errors = [];
        if (!empty($postData)) {
            $data = array_key_exists('SliderItem', $postData) ? $postData['SliderItem'] : [];
            $counter = 0;
            foreach ($data as $key => $beanArray) {
                $bean = new SliderItem();
                if (array_key_exists('image', $beanArray)) {
                    $bean->image = $beanArray['image'];
                }
                else {
                    /**
                     * Load image
                     */
                    if (!array_key_exists($counter, $files)) continue;
                    $file = $files[$counter];
                    $baseName = SiteHelper::translit($file->baseName);
                    $relativePath = $uploadFolder['relativePath'] .  $baseName . "." . $file->extension;
                    $path = $uploadFolder['path'] . $baseName . "." . $file->extension;
                    $file->saveAs($path);
                    $bean->image = $relativePath;
                    $counter++;
                }
                $bean->url = $beanArray['url'];
                $bean->sort = $beanArray['sort'];
                $bean->slider_id = $this->id;
                $bean->save();
            }
        }
        return $errors;
    }

    /**
     * Get directory where customer's file is saved
     * @return string
     * @throws Exception
     */
    public function getUploadFolder()
    {
        $id = $this->id;
        $basePath = \Yii::getAlias('@frontend') . '/web';
        $relativePath = "/uploads/sliders/" . $id . "/";
        $path = [
            'path'         => $basePath . $relativePath,
            'relativePath' => $relativePath
        ];
        BaseFileHelper::createDirectory($path['path']);
        return $path;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (method_exists(\Yii::$app->request, 'post')) {
            $postData = \Yii::$app->request->post();
            $errors = $this->setSliderItems($postData);
            if (!empty($errors)) {
                \Yii::$app->session->setFlash('error', implode(',', $errors));
            }
        }
    }


}

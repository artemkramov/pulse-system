<?php

namespace backend\behaviors;

use backend\components\SiteHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * Class FileBehavior
 * @package backend\behaviors
 */
class FileBehavior extends Behavior
{
    /**
     * @var array
     */
    public $fileAttributes = [];

    /**
     * @var string
     */
    public $folderName = '';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'saveFiles'
        ];
    }

    /**
     * Prepare folders and save all files
     */
    public function saveFiles()
    {
        $owner = $this->owner;
        foreach ($this->fileAttributes as $attribute => $fileAttribute) {
            $owner->{$fileAttribute} = UploadedFile::getInstance($owner, $fileAttribute);
            if (isset($owner->{$fileAttribute})) {
                $basePath = \Yii::getAlias('@frontend') . '/web';
                $className = get_class($owner);
                if (!empty($owner->id)) {
                    $bean = $className::findOne($owner->id);
                    $path = dirname($bean->{$attribute});
                    BaseFileHelper::removeDirectory(\Yii::getAlias("@frontend/web") . $path);
                }

                $relativePath = "/uploads/" . $this->folderName . "/" . SiteHelper::generateUUID() . "/";
                $path = $basePath . $relativePath;
                BaseFileHelper::createDirectory($path);
                $filename = $owner->{$fileAttribute}->baseName . '.' . $owner->{$fileAttribute}->extension;
                $files = glob($path . '*');
                foreach($files as $file){
                    if(is_file($file))
                        unlink($file);
                }
                $owner->{$fileAttribute}->saveAs($path . $filename);
                $owner->{$attribute} = $relativePath . $filename;
            }
        }
    }
}
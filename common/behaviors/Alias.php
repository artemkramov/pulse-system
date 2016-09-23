<?php

namespace common\behaviors;

use backend\components\SiteHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * Class Alias
 * @package common\behaviors
 * Behavior for the autogenerating of the alias
 */
class Alias extends Behavior
{

    /**
     * Attribute from which will be generated alias
     * @var string
     */
    public $inAttribute = 'name';

    /**
     * Attribute where the alias will be saved
     * @var string
     */
    public $outAttribute = 'alias';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'getAlias'
        ];
    }

    /**
     * Set the newly created alias
     */
    public function getAlias()
    {
        $aliasField = $this->outAttribute;
        $titleField = $this->inAttribute;
        $this->owner->{$aliasField} = empty($this->owner->{$aliasField}) ? $this->generateAlias($this->owner->{$titleField}) : $this->owner->{$aliasField};
    }

    /**
     * Generate alias
     * @param $name
     * @return string
     */
    public function generateAlias($name)
    {
        $slug = $this->transformToSlug($name);
        if ($this->checkUniqueSlug($slug)) {
            return $slug;
        } else {
            for ($suffix = 2; !$this->checkUniqueSlug($new_slug = $slug . '-' . $suffix); $suffix++) {
            }
            return $new_slug;
        }
    }

    /**
     * Transform name to slug
     * @param $slug
     * @return string
     */
    private function transformToSlug($slug)
    {
        return Inflector::slug(SiteHelper::translit($slug), '-', true);
    }

    /**
     * Check if the slug is unique in the table
     * @param $slug
     * @return bool
     */
    private function checkUniqueSlug($slug)
    {
        $pk = $this->owner->primaryKey();
        $pk = $pk[0];
        $condition = $this->outAttribute . ' = :out_attribute';
        $params = [':out_attribute' => $slug];
        if (!$this->owner->isNewRecord) {
            $condition .= ' and ' . $pk . ' != :pk';
            $params[':pk'] = $this->owner->{$pk};
        }
        return !$this->owner->find()
            ->where($condition, $params)
            ->one();
    }


}
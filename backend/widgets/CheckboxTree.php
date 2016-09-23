<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 8/8/2016
 * Time: 11:30 AM
 */

namespace backend\widgets;


use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class CheckboxTree
 * @package backend\widgets
 */
class CheckboxTree extends Widget
{

    /**
     * @var array
     */
    public $tree;

    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var array
     */
    public $selectedItems = [];

    /**
     * @var string
     */
    public $titleField = 'title';

    public function run()
    {
        return $this->buildHTML($this->tree);
    }

    private function buildHTML($items, $parentID = null, $level = 0)
    {
        $html = ($level == 0) ? Html::hiddenInput($this->fieldName, '') : '';
        $listTag = ($level == 0) ? 'ul' : 'ol';
        $html .= Html::beginTag($listTag, [
            'class' => ($level == 0) ? 'auto-checkboxes' : ''
        ]);
        foreach ($items as $item) {
            $childHtml = Html::beginTag('li');
            $childHtml .= Html::checkbox($this->fieldName . '[]', in_array($item['id'], $this->selectedItems), [
                'value' => $item['id']
                ]) . ' ' . Html::label($item[$this->titleField]);
            if (array_key_exists('children', $item)) {
                $childHtml .= $this->buildHTML($item['children'], $item['id'], ++$level);
            }
            $childHtml .= Html::endTag('li');
            $html .= $childHtml;
        }
        $html .= Html::endTag($listTag);
        return $html;
    }

}
<?php
echo $form->field($model, 'properties[' . $attribute . ']')->dropDownList($attributeDropdown, [
    'multiple'         => true,
    'class'            => 'chosen-select form-control',
    'data-placeholder' => \common\modules\i18n\Module::t('Select') . ' ' . $title
])->label($title);
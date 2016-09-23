<?php

namespace backend\modules\permit;

class RbacModule extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\permit\controllers';
    public $userClass;

    public function init()
    {
        parent::init();
    }

}
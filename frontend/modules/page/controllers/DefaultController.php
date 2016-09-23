<?php

namespace frontend\modules\page\controllers;

use common\components\Mailer;
use common\models\Post;
use common\modules\i18n\Module;
use frontend\models\ContactForm;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `page` module
 */
class DefaultController extends Controller
{

    /**
     * @param $url
     * @return string
     */
    public function actionShow($url = '')
    {
        if (empty($url)) {
            $post = Post::findDefaultPage();
        }
        else {
            $post = Post::findByAlias($url);
        }

        $template = 'content';
        if (!empty($post->template)) {
            $template = $post->template;
        }
        /**
         * Load custom template if available
         */
        \Yii::$app->params['template'] = $template . '.php';
        $defaultViewName = 'index';
        $view = 'page-' . $post->alias;
        if (!file_exists($this->viewPath . DIRECTORY_SEPARATOR . $view . '.php')) {
            $view = $defaultViewName;
        }
        /**
         * Load extra data
         */
        $extraData = [];
        $actionName = 'loadData' . Inflector::id2camel($post->alias);
        if (method_exists($post, $actionName)) {
            $extraData = $post->{$actionName}();
        }

        /**
         * Call custom action if needed
         */
        $actionName = 'handler' . Inflector::id2camel($post->alias);
        if (method_exists($this, $actionName)) {
            return $this->{$actionName}($view, $post, $extraData);
        }

        return $this->render($view, [
            'post'      => $post,
            'extraData' => $extraData
        ]);
    }

    /**
     * @param $view
     * @param $post
     * @param $extraData
     * @return string
     */
    public function handlerContacts($view, $post, $extraData)
    {
        $contactFormModel = new ContactForm();
        if (\Yii::$app->request->post() && $contactFormModel->load(\Yii::$app->request->post()) && $contactFormModel->validate()) {
            $contactFormModel->sendEmail();
            \Yii::$app->session->setFlash('success', Module::t('Your message was sent successfully. Thank you.'));
            return $this->redirect(Url::current());
        }
        return $this->render($view, [
            'post'        => $post,
            'extraData'   => $extraData,
            'contactForm' => $contactFormModel,
        ]);
    }

}

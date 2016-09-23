<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/23/16
 * Time: 5:42 PM
 */

namespace common\components;

/**
 * Class Mailer
 * @package common\components
 */
class Mailer
{

    /**
     * @var mixed
     */
    private static $mailer;

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param string $from
     * @return mixed
     */
    public static function get($to, $subject, $body, $from = "artemkramov@gmail.com")
    {
        self::$mailer = \Yii::$app->mail->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($body);
        return self::$mailer;
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     */
    public static function sendDefault($to, $subject, $body)
    {
        $mailer = self::get($to, $subject, $body);
        $mailer->send();
    }

}
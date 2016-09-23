<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 6/7/16
 * Time: 1:13 PM
 */

namespace backend\components;

use common\models\Bean;

/**
 * Autoincrement helper to update autoincrement
 * fields of the model
 * @author Artem Kramov
 */
class AutoincrementField
{
    /** @const Function name in SQL to replace all non-numeric characters */
    const SQL_FUNCTION = "returnNumericOnly(%s)";

    /** @const Length of numbers in the DB field */
    const FIELD_LENGTH = 10;

    /**
     * Field name for autoincrement update
     * @var string
     */
    private $fieldName;

    /**
     * Model for which we update data
     * @var Bean
     */
    private $model;

    /**
     * AutoincrementField constructor.
     * @param Bean $_model
     * @param string $_fieldName
     */
    public function __construct($_model, $_fieldName)
    {
        $this->model = $_model;
        $this->fieldName = $_fieldName;
    }

    /**
     * Function for setting of the new autoincrement value
     * @param string $prefix
     */
    public function set($prefix = '')
    {
        $field = $this->fieldName;
        $className = get_class($this->model);
        if (empty($this->model->$field)) {
            /** Get the selector for max value in DB */
            $function = sprintf(self::SQL_FUNCTION, $field);
            $maxValue = $className::find()->max($function);
            if (empty($maxValue)) {
                $maxValue = 0;
            }
            $maxValue++;
            $number = sprintf("%0" . self::FIELD_LENGTH . "d", $maxValue);
            $this->model->$field = $prefix . $number;
        } else {
            $this->model->$field = $prefix . substr($this->model->$field, 1, strlen($this->model->$field));
        }
    }


}
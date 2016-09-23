<?php

namespace backend\models;

use common\models\Bean;
use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $job_id
 * @property string $status
 * @property string $crontab
 *
 * @property Job $job
 */
class Task extends Bean
{
    /**
     * Possible statuses of the task
     * */
    const STATUS_DONE = "done";
    const STATUS_RUNNING = "running";
    const STATUS_ABORTED = "aborted";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'job_id', 'status', 'crontab'], 'required'],
            [['job_id'], 'integer'],
            [['name', 'status', 'crontab'], 'string', 'max' => 255],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::className(), 'targetAttribute' => ['job_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'name'    => 'Name',
            'job_id'  => 'Job ID',
            'status'  => 'Status',
            'crontab' => 'Crontab',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), [
            'id' => 'job_id'
        ]);
    }

}

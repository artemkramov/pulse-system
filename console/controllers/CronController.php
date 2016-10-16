<?php

namespace console\controllers;

use backend\components\CronComponent;
use backend\models\Task;
use Cron\CronExpression;
use yii\console\Controller;

/**
 * Controller for running of the cronjob
 * Always is started from the console
 * */
class CronController extends Controller
{

    /**
     * Entry point of the cron
     */
    public function actionIndex()
    {
        $tasks = Task::find()->all();
        $cronComponent = new CronComponent();
        foreach ($tasks as $task) {
            /**
             * @var Task $task
             */
            $cron = CronExpression::factory($task->crontab);
            $method = $task->job->method;
            /** If cron time is ready and the appropriate handler exists */
            if ($cron->isDue() && method_exists($cronComponent, $method)) {
                $task->status = Task::STATUS_RUNNING;
                $task->save();

                $result = $cronComponent->{$method}();

                $status = (isset($result) && $result) ? Task::STATUS_DONE : Task::STATUS_ABORTED;
                $task->status = $status;
                $task->save();
            }
        }
    }

}
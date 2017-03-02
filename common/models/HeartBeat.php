<?php

namespace common\models;

use common\modules\i18n\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "heart_beat".
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $ibi
 *
 * @property User $user
 */
class HeartBeat extends Bean
{

    const DATE_PRECISION = 1000000;

    const COEFFICIENT_MILLISECONDS = 1000;

    /**
     * Minimal interval between heart beat (in ms)
     */
    const MINIMAL_INTERVAL = 50;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heart_beat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['ibi'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('Id'),
            'user_id'    => Module::t('User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getDataPointsFromBeats($beats)
    {
        $previousBeat = null;
        $dataPoints = [];
        foreach ($beats as $beat) {
            /**
             * @var HeartBeat $beat
             * @var HeartBeat $previousBeat
             */
            if (isset($previousBeat)) {
                $diff = self::getTimeBetweenBeats($previousBeat, $beat);
                $dt = new \DateTime($previousBeat->ibi);
                $interval = self::MINIMAL_INTERVAL;
                $counter  = $interval;

                while ($counter < $diff) {
                    $counterSecond = 0;
                    $dt = new \DateTime($previousBeat->ibi);
                    $microseconds = round(self::COEFFICIENT_MILLISECONDS * $dt->format('u') / self::DATE_PRECISION) + $counter;
                    if ($microseconds >= self::COEFFICIENT_MILLISECONDS) {
                        while ($microseconds >= self::COEFFICIENT_MILLISECONDS) {
                            $microseconds -= self::COEFFICIENT_MILLISECONDS;
                            $counterSecond++;
                        }
                        $dt->add(new \DateInterval("PT" . $counterSecond . "S"));
                    }
                    $newDateTime = new \DateTime($dt->format('Y-m-d H:i:s.' . sprintf("%03d", $microseconds)));
                    $dataPoints[] = [
                        'x' => $newDateTime->format('Y-m-d H:i:s.u'),
                        'y' => 0,
                    ];
                    $prevDateTime = $newDateTime;
                    $counter += $interval;
                }
                $dataPoints[] = [
                    'x' => $beat->ibi,
                    'y' => 1
                ];
            }
            $previousBeat = $beat;

        }
        return $dataPoints;
    }

    /**
     * @param HeartBeat $firstBeat
     * @param HeartBeat $secondBeat
     * @return float|int
     */
    public static function getTimeBetweenBeats($firstBeat, $secondBeat)
    {
        $time = strtotime($secondBeat->ibi) - strtotime($firstBeat->ibi);
        $dtFirst = new \DateTime($firstBeat->ibi);
        $dtSecond = new \DateTime($secondBeat->ibi);
        $time = round(self::COEFFICIENT_MILLISECONDS * abs($time + ($dtSecond->format('u') - $dtFirst->format('u')) / self::DATE_PRECISION));
        return $time;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @param $userID
     * @return float|int
     */
    public static function getBPMInRange($startTime, $endTime, $userID)
    {
        $beats = self::find()
            ->where(sprintf("`ibi` BETWEEN FROM_UNIXTIME(%s) AND FROM_UNIXTIME(%s)", $startTime, $endTime))
            ->andWhere(["user_id" => $userID])
            ->count();
        $range = $endTime - $startTime;
        $bpm = 0;
        if ($range != 0) {
            $bpm = round(($beats / $range) * 60);
        }
        return $bpm;
    }

}

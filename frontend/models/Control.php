<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "control".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $monday
 * @property integer $tuesday
 * @property integer $wednesday
 * @property integer $thursday
 * @property integer $friday
 * @property integer $week
 * @property integer $h_total
 */
class Control extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'control';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_user', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'week', 'h_total'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'week' => 'Week',
            'h_total' => 'H Total',
        ];
    }

}

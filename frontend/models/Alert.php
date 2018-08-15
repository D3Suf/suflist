<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "alert".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_ceo
 * @property string $type
 * @property string $date_alert
 * @property string $obs
 * @property integer $check_alert
 * @property string $obs_ceo
 * @property string $from_to
 * @property string $data_insert
 * @property string $data_update
 */
class Alert extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'alert';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'data_insert',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'data_update',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_user', 'id_ceo'], 'required'],
            [['id_user', 'id_ceo', 'date_alert', 'h_inicio', 'h_pausa', 'h_final', 'h_total'], 'integer'],
            [['data_insert', 'data_update'], 'safe'],
            [['type', 'check_alert', 'from_to'], 'string', 'max' => 255],
            [['obs', 'obs_ceo'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_ceo' => 'Id Ceo',
            'type' => 'Type',
            'date_alert' => 'Date Alert',
            'obs' => 'Obs',
            'check_alert' => 'Check Alert',
            'h_inicio' => 'H Inicio',
            'h_pausa' => 'H Pausa',
            'h_final' => 'H Final',
            'h_total' => 'H Total',
            'obs_ceo' => 'Obs Ceo',
            'from_to' => 'From To',
            'data_insert' => 'Data Insert',
            'data_update' => 'Data Update',
        ];
    }

}

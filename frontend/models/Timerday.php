<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "timerday".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $h_inicio
 * @property integer $h_pausa
 * @property integer $h_final
 * @property string $status
 * @property integer $h_check
 * @property integer $h_total
 * @property string $dia
 * @property string $data_insert
 * @property string $data_update
 */
class Timerday extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'timerday';
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
            [['id_user'], 'required'],
            [['id_user', 'h_inicio', 'h_pausa', 'h_final', 'h_check', 'h_total'], 'integer'],
            [['data_insert', 'data_update'], 'safe'],
            [['status', 'dia'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'h_inicio' => 'H Inicio',
            'h_pausa' => 'H Pausa',
            'h_final' => 'H Final',
            'status' => 'Status',
            'h_check' => 'H Check',
            'h_total' => 'H Total',
            'dia' => 'Dia',
            'data_insert' => 'Data Insert',
            'data_update' => 'Data Update',
        ];
    }

}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "timertotal".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $data_inicio
 * @property string $data_final
 * @property integer $hs_total
 * @property string $day
 * @property string $week
 */
class Timertotal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timertotal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user', 'hs_total'], 'integer'],
            [['data_inicio'], 'safe'],
            [['data_final', 'day', 'week'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'data_inicio' => 'Data Inicio',
            'data_final' => 'Data Final',
            'hs_total' => 'Hs Total',
            'day' => 'Day',
            'week' => 'Week',
        ];
    }
}

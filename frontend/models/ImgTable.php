<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "img_table".
 *
 * @property integer $id
 * @property string $email
 * @property integer $facebook_id
 */
class ImgTable extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'img_table';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'facebook_id'], 'required'],
            [['email', 'facebook_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'facebook_id' => 'Facebook ID',
        ];
    }

}

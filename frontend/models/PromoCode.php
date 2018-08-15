<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "promo_code".
 *
 * @property integer $id
 * @property string $code_name
 */
class PromoCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_name'], 'required'],
            [['code_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_name' => 'Code Name',
        ];
    }
}

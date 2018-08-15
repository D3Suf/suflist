<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class PasswordForm extends Model {

    public $oldpassword;
    public $newpassword;
    public $repeatnewpassword;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['oldpassword', 'newpassword', 'repeatnewpassword'], 'required'],
            ['oldpassword', 'findPassword'],
            ['repeatnewpassword', 'compare', 'compareAttribute' => 'newpassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'oldpassword' => 'Old Password',
            'newpassword' => 'New Password',
            'repeatnewpassword' => 'Repeat New Password',
        ];
    }

    public function findPassword($attribute, $params) {
        $user = User::find()
                ->where(['id' => Yii::$app->user->id])
                ->one();

//        $old = Yii::$app->security->generatePasswordHash($this->oldpassword);
        $password = $user->password_hash;

        $x = Yii::$app->security->validatePassword($this->oldpassword, $password);
//        var_dump($x);
//        die;
        if ($x == FALSE) {
            $this->addError($attribute, 'Password antiga está incorreta');
        }
    }

}

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-changepassword">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to change password :</p>


    <?php $form = ActiveForm::begin(['id' => 'changepassword-form']); ?>

    <?=
    $form->field($model, 'oldpassword', ['options' => [
            'tag' => 'div',
            'class' => ' input-group input-group-icon form-group field-logginform-password has-feedback required'
        ],
        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                 {error}{hint}'
    ])->passwordInput(['placeholder' => 'Old Password'])
    ?>

    <?=
    $form->field($model, 'newpassword', ['options' => [
            'tag' => 'div',
            'class' => ' input-group input-group-icon form-group field-logginform-password has-feedback required'
        ],
        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                 {error}{hint}'
    ])->passwordInput(['placeholder' => 'New Password'])
    ?>

    <?=
    $form->field($model, 'repeatnewpassword', ['options' => [
            'tag' => 'div',
            'class' => ' input-group input-group-icon form-group field-logginform-password has-feedback required'
        ],
        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                 {error}{hint}'
    ])->passwordInput(['placeholder' => 'Repeat New Password'])
    ?>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Change password <i class="fa fa-sign-in" aria-hidden="true"></i>', ['class' => 'btn btn-primary hidden-xs', 'name' => 'login-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>



</div>
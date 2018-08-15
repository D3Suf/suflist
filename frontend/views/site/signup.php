<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <!--start: page -->

    <div class="row msg_topo">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 text-center">
            <?php
            $data = date("H");
            if ($data >= '07' && $data <= '13') {
                echo '<p class="msg"> Olá, são ' . date("H:i") . ' <br> Vamos aproveitar o dia! </p>';
            } elseif ($data <= '19') {
                echo '<p class="msg"> Boa tarde, são ' . date("H:i") . ' <br> O dia terminar bem só depende de nós. Vamos fazê-lo juntos? </p>';
            } else {
                echo '<p class="msg"> Olá, são ' . date("H:i") . ' <br> O dia só termina quando vamos dormir, verdade? </p>';
            }
            ?>
        </div>
    </div>

    <section class = "body-sign">
        <div class = "center-sign">
            <div class = "panel panel-sign">
                <div class = "panel-title-sign mt-xl text-right">
                    <h2 class = "title text-uppercase text-bold m-none"><i class = "fa fa-user mr-xs"></i> Registo</h2>
                </div>
                <div class = "panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?=
                    $form->field($model, 'username', ['options' => [
                            'tag' => 'div',
                            'class' => 'input-group input-group-icon form-group field-logginform-username has-feedback required'
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>
                                 {error}{hint}'
                    ])->textInput(['placeholder' => 'Introduza o Username'])->label('go')
                    ?>

                    <?=
                    $form->field($model, 'email', ['options' => [
                            'tag' => 'div',
                            'class' => 'input-group input-group-icon form-group field-logginform-username has-feedback required'
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                 {error}{hint}'
                    ])->textInput(['placeholder' => 'Introduza o seu email'])->label('go')
                    ?>

                    <?=
                    $form->field($model, 'password', ['options' => [
                            'tag' => 'div',
                            'class' => ' input-group input-group-icon form-group field-logginform-password has-feedback required'
                        ],
                        'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                 {error}{hint}'
                    ])->passwordInput(['placeholder' => 'Introduza a sua Password'])
                    ?>

                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8 text-right">
                            <?= Html::submitButton('Entrar <i class="fa fa-sign-in" aria-hidden="true"></i>', ['class' => 'btn btn-primary hidden-xs', 'name' => 'signup-button']) ?>
                        </div>
                    </div>

                    <span class = "mt-lg mb-lg line-thru text-center text-uppercase">
                        <span>or</span>
                    </span>

                    <div class = "mb-xs text-center">
                        <a class = "btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class = "fa fa-facebook"></i></a>
                        <a class = "btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class = "fa fa-twitter"></i></a>
                    </div>

                    <p class = "text-center">Já possui conta? <a href="<?= Url::to(['site/login']); ?>"> Faça login aqui!</a>

                        <?php ActiveForm::end(); ?>
                </div>
            </div>

            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2017. SufList All Rights Reserved.</p>
        </div>
    </section>
    <!-- end: page -->
</div>

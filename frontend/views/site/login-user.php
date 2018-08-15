<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login User';
?>

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
        <!--        <a href = "/" class = "logo pull-left">
                    <img src = "assets/images/logo.png" height = "54" alt = "Porto Admin" />
                </a>-->

        <div class = "panel panel-sign">
            <div class = "panel-title-sign mt-xl text-right">
                <h2 class = "title text-uppercase text-bold m-none"><i class = "fa fa-user mr-xs"></i> Iniciar Sessão</h2>
            </div>
            <div class = "panel-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <div class="form-group mb-lg">
                    <label>Email</label>
                    <div class="input-group input-group-icon">
                        <input name="username" type="text" class="form-control input-lg" placeholder="Introduza o seu email" />
                        <span class="input-group-addon">
                            <span class="icon icon-lg">
                                <i class="fa fa-user"></i>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="form-group mb-lg">
                    <div class="clearfix">
                        <label class="pull-left">Password</label>
                        <a href="pages-recover-password.html" class="pull-right">Esqueceu-se da Password?</a>
                    </div>
                    <div class="input-group input-group-icon">
                        <input name="pwd" type="password" class="form-control input-lg" placeholder="Introduza a sua Password" />
                        <span class="input-group-addon">
                            <span class="icon icon-lg">
                                <i class="fa fa-lock"></i>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-8 text-right">
                        <button type="submit" class="btn btn-primary hidden-xs"> Entrar <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                        <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg"> Entrar <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                    </div>
                </div>

                <span class = "mt-lg mb-lg line-thru text-center text-uppercase">
                    <span>or</span>
                </span>

                <div class = "mb-xs text-center">
                    <a class = "btn btn-facebook mb-md ml-xs mr-xs">Connect with <i class = "fa fa-facebook"></i></a>
<!--                        <a class = "btn btn-twitter mb-md ml-xs mr-xs">Connect with <i class = "fa fa-twitter"></i></a>-->
                </div>

                <p class = "text-center">Não consegue entrar? <a href="pages-signup.html"> Contacte-nos</a>

                    <?php ActiveForm::end(); ?>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2017. SufList All Rights Reserved.</p>
    </div>
</section>
<!-- end: page -->


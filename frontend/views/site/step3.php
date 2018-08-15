<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\controllers\SiteController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container">
    <div class="row msg_topo">
        <div class="col-lg-12 col-lg-offset-0 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <p class="msg_setup">
                <?= Html::img(Yii::getAlias('@web') . '/img/suflogov4.png', ['alt' => 'Carlos Sousa Logo']); ?>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <section class="panel form-wizard" id="w4">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>

                    <h2 class="panel-title">Setup</h2>
                </header>
                <?= Html::beginForm(['site/complete'], 'post', ['class' => 'form-horizontal', 'role' => 'form']); ?>
                <div class="panel-body">
                    <div class="wizard-progress wizard-progress-lg">
                        <div class="steps-progress">
                            <div class="progress-indicator"></div>
                        </div>
                        <ul class="wizard-steps">
                            <li>
                                <a href="#" data-toggle="tab"><span>1</span>Company Info</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="tab"><span>2</span>Offices Info</a>
                            </li>
                            <li class="active">
                                <a href="#" data-toggle="tab"><span>3</span>Confirmation</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div id="w4-account" class="tab-pane active ">
                            <div class="col-lg-12 text-center">
                                <?= Html::img(Yii::getAlias('@web') . '/img/suflogov4.png', ['alt' => 'Carlos Sousa Logo']); ?>
                            </div>
                            <div class="row msg_topo">
                                <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                                    <p class="msg_complete">
                                        <strong>Instalação Completa</strong>
                                    </p>
                                    <p class="black">
                                        BeforeParty foi instalado com sucesso, para a sua empresa <strong> <?php echo Yii::$app->user->identity->company ?> </strong> <br/>
                                        <br/>
                                        A BeforeParty é uma plataforma desenhada para funcionar em ambiente Intranet, onde grande parte das suas funcionalidas só estão disponiveis se estiver ligado a internet da sua empresa, tendo assim uma maior fidelidade. <br/>
                                        <br/>
                                        Desse modo para terminar é necessario inserir abaixo o IP da sua empresa. <br/>
                                    </p>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <?php
                                            $ip = SiteController::getRealIp();
                                            ?>
                                            <input type="text" class="form-control" name="ip" id="ip" value='<?php echo $ip ?>' required>
                                        </div>
                                        <label class="col-sm-6 black" for="w4-last-name">é este o IP da sua empresa?</label>
                                    </div>
                                    <p class='black'>
                                        <br/>
                                        <small>Se tiver dúvidas de como colocar o ip correcto, <a href='#'>clique aqui!</a></small>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <p class='black'>
                                        <small> Para terminar verifique e aceite os termos e condições. </small>
                                    </p>
                                    <div class="checkbox-custom">
                                        <input type="checkbox" name="checkt" id='checkt' id="w4-terms" value="1" required>
                                        <label class="black"> Eu aceito os <a href="#">Termos e Condições SufList</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                                    <p class="black">
                                        Clique em finish para terminar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="pager">
                        <li class="previous disabled">
                            <a href="#"><i class="fa fa-angle-left"></i> Previous</a>
                        </li>
                        <li class="next">
                            <button type="submit" class="btn btn-primary hidden-xs btnsetup btn-loading">Finish</button>
                        </li>
                    </ul>
                </div>
                <?= Html::endForm(); ?>
            </section>
        </div>
    </div>
</div>
<!-- end: page -->



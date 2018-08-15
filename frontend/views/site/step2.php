<?php

use yii\helpers\Url;
use yii\helpers\Html;

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

    <?= Yii::$app->session->getFlash('aviso') ?>

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
                <?= Html::beginForm(['site/newoffice'], 'post', ['class' => 'form-horizontal', 'role' => 'form']); ?>
                <div class="panel-body">
                    <div class="wizard-progress wizard-progress-lg">
                        <div class="steps-progress">
                            <div class="progress-indicator"></div>
                        </div>
                        <ul class="wizard-steps">
                            <li>
                                <a href="<?= Url::to(['site/step1']) ?>" data-toggle="tab"><span>1</span>Company Info</a>
                            </li>
                            <li class="active">
                                <a href="#" data-toggle="tab"><span>2</span>Offices Info <br/> <small style="font-size: 10px">Insira os emails dos <br/> seus <strong> <?php echo $company->n_funcionarios ?> </strong> funcionarios</small></a>
                            </li>
                            <li>
                                <a href="#" data-toggle="tab"><span>3</span>Confirmation</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div id="w4-account" class="tab-pane active ">
                            <?php
                            $i = $company->n_funcionarios;

                            for ($i; $i != 0; $i--) {
                                echo '<div class="form-group">
                                        <label class="col-sm-4 control-label black" for="w4-first-name">Email </label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" name="' . $i . '" id="' . $i . '" required placeholder="Insira os emails dos seus funcionarios">
                                        </div>
                                      </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="pager">
                        <li class="previous">
                            <a href='<?= Url::to(['site/step1']) ?>'><i class="fa fa-angle-left"></i> Previous</a>
                        </li>
                        <li class="finish hidden pull-right">
                            <a>Finish</a>
                        </li>
                        <!--                        <li class="next">
                                                    <a>Next <i class="fa fa-angle-right"></i></a>
                                                </li>-->
                        <li class="next">
                            <button type="submit" class="btn btn-primary hidden-xs btnsetup btn-loading">Next <i class="fa fa-angle-right"></i></button>
                        </li>
                    </ul>
                </div>
                <?= Html::endForm(); ?>
            </section>
        </div>
    </div>
</div>
<!-- end: page -->


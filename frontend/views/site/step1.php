<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\time\TimePicker;

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
                <?= Html::beginForm(['site/newcompany'], 'post', ['class' => 'form-horizontal', 'role' => 'form']); ?>
                <div class="panel-body">
                    <div class="wizard-progress wizard-progress-lg">
                        <div class="steps-progress">
                            <div class="progress-indicator"></div>
                        </div>
                        <ul class="wizard-steps">
                            <li class="active">
                                <a href="#w4-profile" data-toggle="tab"><span>1</span>Company Info</a>
                            </li>
                            <li>
                                <a href="#w4-billing" data-toggle="tab"><span>2</span>Offices Info</a>
                            </li>
                            <li>
                                <a href="#w4-confirm" data-toggle="tab"><span>3</span>Confirmation</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div id="w4-account" class="tab-pane active ">
                            <div class="form-group">
                                <label class="col-sm-4 control-label black" for="w4-first-name">Nome da empresa</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nome" id="nome" value='<?php echo $model->company ?>' required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label black" for="w4-last-name">Numero de funcionarios</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="funcionarios" id="funcionarios" value='<?php
                                    if ($value != 'empty') {
                                        echo $value->n_funcionarios;
                                    }
                                    ?>' required placeholder='Insira o número de funcionarios da sua empresa'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label black" for="w4-last-name">Hora de entrada <small>(obrigatoria*)</small></label>
                                <div class="col-sm-4">
                                    <?php
                                    if ($value != 'empty') {
                                        $x = date('H:i', ($value->h_inicio));
                                    } else {
                                        $x = '09:30';
                                    }

                                    echo TimePicker::widget([
                                        'name' => 'start_time',
                                        'value' => $x,
                                        'pluginOptions' => [
                                            'showSeconds' => false,
                                            'showMeridian' => false,
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label black" for="w4-last-name">Hora de Saida <small>(obrigatoria*)</small></label>
                                <div class="col-sm-4">
                                    <?php
                                    if ($value != 'empty') {
                                        $x = date('H:i', ($value->h_final));
                                    } else {
                                        $x = '17:30';
                                    }

                                    echo TimePicker::widget([
                                        'name' => 'end_time',
                                        'value' => $x,
                                        'pluginOptions' => [
                                            'showSeconds' => false,
                                            'showMeridian' => false,
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label black" for="w4-last-name">Numero de horas semanais <small>(obrigatorias*)</small></label>
                                <div class="col-sm-4">
                                    <input type="number" value='<?php
                                    if ($value != 'empty') {
                                        echo $value->h_trabalho_s;
                                    } else {
                                        echo '40';
                                    }
                                    ?>' class="form-control" name="hsemanal" id="hsemanal" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="pager">
                        <li class="previous disabled">
                            <a href='<?= Url::to(['site/step1']) ?>'><i class="fa fa-angle-left"></i> Previous</a>
                        </li>
                        <li class="finish hidden pull-right">
                            <a>Finish</a>
                        </li>
                        <!--                        <li class="next">
                                                    <a>Next <i class="fa fa-angle-right"></i></a>
                                                </li>-->
                        <li class="next">
                            <button type="submit" class="btn btn-primary hidden-xs btnsetup">Next <i class="fa fa-angle-right"></i></button>
                        </li>
                    </ul>
                </div>
                <?= Html::endForm(); ?>
            </section>
        </div>
    </div>
</div>
<!-- end: page -->
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use frontend\controllers\SiteController;
use kartik\time\TimePicker;
use yii2mod\alert\Alert;

//var_dump($value);
//die;
?>

<header class="page-header">
    <h2>Pagina de Alertas </h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="<?= Url::to(['site/view-user']); ?>">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Pagina de Alertas </span></li>
        </ol>

        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<?= Yii::$app->session->getFlash('aviso') ?>

<?php
$success = Yii::$app->session->getFlash('success');
$error = Yii::$app->session->getFlash('error');
if (!empty($success) || !empty($error)) {
    echo Alert::widget();
}
?>



<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Todas as informações sobre os seus funcionários </h2>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-no-more table-bordered  mb-none">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Hora e Data do Alerta</th>
                                <th>Observação</th>
                                <th>Acção</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($model as $alert) {
                                //find username
                                $user = User::find()
                                        ->where(['id' => $alert->id_user])
                                        ->one();

                                echo ' <tr>
                                        <td><strong>' . $user->username . '</strong></td>';
                                if ($alert->type == 'Atraso') {
                                    echo ' <td> <i class="fa fa-warning fa-fw text-warning text-md va-middle"></i> <span class="text-warning"><strong> ' . $alert->type . ' </strong></span> </td>';
                                } elseif ($alert->type == 'Saida antes da hora') {
                                    echo ' <td> <i class="fa fa-warning fa-fw text-danger text-md va-middle"></i> <span class="text-warning"><strong> ' . $alert->type . ' </strong></span> </td>';
                                } else {
                                    echo ' <td> <i class="fa fa-ban fa-fw text-danger text-md va-middle"></i> <span class="text-danger upalert"><strong> ' . $alert->type . ' </strong></span> </td>';
                                }
                                if ($alert->type == 'Não fechou o dia') {
                                    $dayalert = SiteController::getAlertday($alert->h_inicio);
                                } else {
                                    $dayalert = SiteController::getAlertday(strtotime($alert->data_insert));
                                }
                                if ($dayalert == TRUE) {
                                    echo '<td> <strong> Hoje as ' . date('H:i:s', strtotime($alert->data_insert)) . '</td>';
                                } elseif ($alert->type == 'Não fechou o dia') {
                                    echo '<td>' . date('d/F/Y', $alert->h_inicio) . '</td>';
                                } else {
                                    echo '<td>' . date('d/F/Y H:i:s', strtotime($alert->data_insert)) . '</td>';
                                }
                                if (!empty($alert->obs)) {
                                    echo '<td> <a class="mb-xs mt-xs mr-xs modal-basic" href="#' . $alert->id . '"><i class="fa fa-info-circle fa-fw text-info text-lg va-middle"></i> <strong> ver mais ... </strong></a> </td>';
                                } else {
                                    echo '<td> sem justificação </td>';
                                }
                                if ($alert->type == 'Não fechou o dia') {
                                    echo '<td>' . Html::a('Validar', Url::to(['site/validardia', 'id' => $alert->id]), ['class' => 'btn btn-xs btn-success', 'data' => [
                                            'confirm' => 'Confirma que quer validar <br/> o alerta "<span style="color: #dd4b39">' . $alert->type . '</span>" <br/> ao utilizador <span style="color: #dd4b39"> ' . $user->username . '  </span>?',
                                            'method' => 'post',
                                        ],]) . ' ' .
                                    Html::a('Não Validar', Url::to(['site/naovalidardia', 'id' => $alert->id]), ['class' => 'btn btn-xs btn-danger', 'data' => [
                                            'confirm' => 'Confirma que <strong> NÃO QUER </strong> validar o alerta <br/> "<span style="color: #dd4b39">' . $alert->type . '</span>" <br/> ao utilizador <span style="color: #dd4b39"> ' . $user->username . '  </span>?',
                                            'method' => 'post',
                                        ],]) .
                                    '</td>';
                                } elseif ($alert->type == 'Atraso') {
                                    echo '<td> <a class="btn btn-xs btn-success modal-with-form" href="#' . $alert->id . 'atraso">Validar</a> ';
                                    echo Html::a('Não Validar', Url::to(['site/naovalidaratraso', 'id' => $alert->id]), ['class' => 'btn btn-xs btn-danger', 'data' => [
                                            'confirm' => 'Confirma que <strong> NÃO QUER </strong> validar o alerta "<span style="color: #dd4b39">' . $alert->type . '</span>" <br/> ao utilizador <span style="color: #dd4b39"> ' . $user->username . '  </span>?',
                                            'method' => 'post',
                                        ],]) .
                                    '</td>';
                                }
                                echo '</tr>';
                                //info modal
                                echo '<div id="' . $alert->id . '" class="modal-block modal-header-color modal-block-info mfp-hide">
                                            <section class="panel">
                                                    <header class="panel-heading">
                                                            <h2 class="panel-title">Detalhes da justificação </h2>
                                                    </header>
                                                    <div class="panel-body">
                                                            <div class="modal-wrapper">
                                                                    <div class="modal-icon">
                                                                            <i class="fa fa-info-circle"></i>
                                                                    </div>
                                                                    <div class="modal-text">
                                                                            <h4> <strong>' . $user->username . '</strong> alerta de "<strong>' . $alert->type . '</strong>"</h4>
                                                                            <p> <br/> <strong>Justificação: </strong>"' . $alert->obs . '"</p>';
                                if ($alert->type == 'Não fechou o dia') {
                                    echo '<p> <small> Hora de saida dita pelo o utilizador: </small> <strong> ' . date('d/F/Y H:i:s', $alert->h_final) . ' </strong></p>';
                                    echo '<p> <small> Se validar este alerta o utilizador <strong>' . $user->username . '</strong> terá trabalhado: </small> <br/> <small> cerca de :</small> <strong> ' . number_format(($alert->h_total / 3600), 1) . '</strong><small> hora(s) nesse dia </small></p>';
                                }
                                echo'
                                                                    </div>
                                                            </div>
                                                    </div>
                                                    <footer class="panel-footer">
                                                            <div class="row">
                                                                    <div class="col-md-12 text-right">
                                                                            <button class="btn btn-info modal-dismiss">OK</button>
                                                                    </div>
                                                            </div>
                                                    </footer>
                                            </section>
                                    </div>';
                                //atraso modal
                                echo '<div id="' . $alert->id . 'atraso" class="modal-block modal-block-primary mfp-hide">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            <h2 class="panel-title">Indique a hora de chegada do ' . $user->username . '</h2>
                                        </header>
                                        <div class="panel-body">';
                                echo Html::beginForm(['site/validaratraso', 'id' => $alert->id], 'post', ['class' => 'form-horizontal mb-lg', 'role' => 'form']);
                                echo ' <div class="form-group mt-lg">
                                                <label class="col-sm-3 control-label">Hora de chegada</label>
                                                <div class="col-sm-9">';

                                echo TimePicker::widget([
                                    'name' => 'hora_chegada',
                                    'value' => '09:30',
                                    'pluginOptions' => [
                                        'showSeconds' => false,
                                        'showMeridian' => false,
                                    ]
                                ]);

                                echo' </div>
                                        </div>
                                        </div>
                                        <footer class="panel-footer">
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                    <button class="btn btn-default modal-dismiss">Cancelar</button>
                                                </div>
                                            </div>
                                        </footer>';
                                echo Html::endForm();
                                echo' </section>
                                </div>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
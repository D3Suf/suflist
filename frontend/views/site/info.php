<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use frontend\models\Control;

//var_dump($value);
//die;

header("Refresh: 120; URL=http://www.myschedule.iconsulting-group.com");
?>

<header class="page-header">
    <h2>Pagina de Informação </h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="<?= Url::to(['site/view-user']); ?>">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Pagina de Informação </span></li>
        </ol>

        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
</header>

<?= Yii::$app->session->getFlash('aviso') ?>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Todas as informações sobre os funcionários </h2>
            </header>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-none">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Semana</th>
                                <th>Nº horas</th>
                                <th>info</th>
                                <th>Nº atrasos</th>
                                <th>Nº faltas</th>
                                <th>Nº saidas antecipadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($control as $model) {
                                $user = User::find()
                                        ->where(['id' => $model->id_user])
                                        ->one();

                                echo '<tr>
                                        <td>' . $user->username . '</td>
                                        <td>' . $model->week . '</td>
                                        <td>' . round($model->h_total / 3600) . '</td>
                                        <td> ver tudo </td>
                                        <td> + </td>
                                        <td> + </td>
                                        <td> + </td>
                                    </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
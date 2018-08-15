<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii2mod\alert\Alert;

header("Refresh: 120; URL=http://www.myschedule.iconsulting-group.com");
?>

<header class="page-header">
    <h2>Pagina de Perfil | Visão Global </h2>

    <div class="right-wrapper pull-right">
        <ol class="breadcrumbs">
            <li>
                <a href="<?= Url::to(['site/view-user']); ?>">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li><span>Pagina de perfil</span></li>
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

<!-- start: page -->

<div class="row">
    <div class="col-lg-4 col-lg-offset-0 col-md-8 col-md-offset-2">

        <section class="panel">
            <div class="panel-body">
                <div class="thumb-info mb-md">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        if (Yii::$app->user->identity->photo == 'default-profile') {
                            echo Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'rounded img-responsive', 'alt' => 'default user']);
                        } else {
                            //foto de perfil
                            echo '<img class="rounded img-responsive" src="http://graph.facebook.com/' . Yii::$app->user->identity->photo . '/picture?width=350&height=350" />';
                        }
                    }
                    ?>
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner"><?php echo Yii::$app->user->identity->username ?></span>
                        <span class="thumb-info-type">
                            <?php
                            if (Yii::$app->user->identity->ceo == 2) {
                                echo 'CEO';
                            } else {
                                echo 'Funcionário';
                            }
                            ?>
                        </span>
                    </div>
                </div>

                <div class="widget-toggle-expand mb-md">
                    <div class="widget-header">
                        <h6>Profile Completion</h6>
                        <div class="widget-toggle">+</div>
                    </div>
                    <div class="widget-content-collapsed">
                        <div class="progress progress-xs light">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                                60%
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-expanded">
                        <ul class="simple-todo-list">
                            <li class="completed">Registo na aplicação SufList</li>
                            <li class="completed">Login e primeiro contacto com a aplicação</li>
                            <li><a href="<?= Url::to(['site/changepassword']); ?>">Trocar Password</a></li>
                            <li><a href="#">Enviar uma Sugestão de melhoria</a></li>
                        </ul>
                    </div>
                </div>

                <hr class="dotted short">

                <h6 class="text-muted">Sobre mim</h6>
                <p>A Andreia não fala latim por isso por agora vai ficar assim :D</p>

                <hr class="dotted short">

                <div class="social-icons-list">
                    <a rel="tooltip" data-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
                    <a rel="tooltip" data-placement="bottom" href="http://www.twitter.com" data-original-title="Twitter"><i class="fa fa-twitter"></i><span>Twitter</span></a>
                    <a rel="tooltip" data-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
                </div>

            </div>
        </section>

    </div>
    <div class="col-md-12 col-lg-7">
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading panel-heading-transparent">
                        <h2 class="panel-title">Indicadores de desempenho <small>(por utilizador unico)</small></h2>

                    </header>
                    <div class="panel-body transpanel">

                        <div class="col-lg-12 text-center">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <h2 class="panel-title mt-md">Objectivo Semanal <small><i><u>(40horas)</u></i></small></h2>
                                    <div class="liquid-meter-wrapper liquid-meter-sm mt-lg">
                                        <div class="liquid-meter">
                                            <meter min="0" max="200" value="<?php echo $total_semana ?>" id="meterSales"></meter>
                                        </div>
                                        <div class="liquid-meter-selector" id="meterSalesSel">
                                            <a href="#" data-val="<?php echo $total_semana ?>" class="active">Semana Atual</a>
                                            <a href="#" data-val="<?php echo $total_semanapassada ?>">Semana Passada</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div class="col-md-4 col-md-offset-2">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title"><small>Nº de Faltas</small></h4>
                                                <div class="info">
                                                    <strong class="amount"><small>&infin;</small></strong>
                                                    <span class="text-success"> <small> <i class="fa fa-caret-down" aria-hidden="true"></i> brevemente </small></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title"><small>Saida antecipada</small></h4>
                                                <div class="info">
                                                    <strong class="amount"><small><?php echo $n_saida ?> vezes</small></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title"><small>Chegou atrasado</small></h4>
                                                <div class="info">
                                                    <strong class="amount"><small><?php echo $n_atraso ?> vezes</small></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>                        
                        <div class="col-md-4">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title"><small>Horas em falta</small></h4>
                                                <div class="info">
                                                    <strong class="amount"><small><?php
                                                            if ($horas_falta <= 8) {
                                                                echo '<span class="text-success">' . $horas_falta . '</span>';
                                                            } else {
                                                                echo '<span class="text-danger">' . $horas_falta . '</span>';
                                                            }
                                                            ?>
                                                        </small>
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>                        
                    </div>
                </section>

                <section class="panel mt10">
                    <header class="panel-heading">
                        <h2 class="panel-title text-right"><strong><?php echo date('d-M-Y', time()) ?></strong>
                            <br/>
                            <small> <i class="fa fa-square text-success" aria-hidden="true"></i> valor acima de 8 de horas de trabalho </small>
                            <br/>
                            <small> <i class="fa fa-square text-danger" aria-hidden="true"></i> valor abaixo de 8 de horas de trabalho </small>
                        </h2>
                        <h2 class="panel-title"><small> Horas de trabalho da semana de dia <?php
                                $x = date('N', time());
                                $inicio = date('d', strtotime('-' . $x . 'days'));
                                $y = 6 - $x;
                                $final = date('d', strtotime('+' . $y . 'days'));

                                echo $inicio . ' a ' . $final
                                ?></small>
                        </h2>
                        <p class="panel-subtitle"><small>As horas do dia de hoje <?php echo date('d', time()) ?> só irão ser processadas após o final do dia. Pode consultar as mesmas no Temporizador do cabeçalho </small></p>
                    </header>
                    <div class="panel-body">

                        <!-- Flot: Bars -->
                        <div class="chart chart-md" id="flotBars"></div>
                        <script type="text/javascript">

                            var grafico = <?= $value ?>;
                            var flotBarsData = [];
                            var i = 0;
                            var gcolor;
                            for (var key in grafico) {
                                if (grafico.hasOwnProperty(key)) {
                                    var time = grafico[key];
                                    gcolor = time < 8 ? 'red' : '#09c309';
                                    flotBarsData[i++] = {data: [[key, grafico[key]]], color: gcolor};
                                }
                            }

                            //                            var grafico = <?= $value ?>;
//                            var i = 0;
//
//                            var flotBarsData = [];
//                            for (var key in grafico) {
//                                if (grafico.hasOwnProperty(key)) {  // grafico.hasOwnProperty(key) serve para verificar se existe objecto 
//                                    flotBarsData[i++] = [key, grafico[key]]
//                                }
//                            }

                            // See: assets/javascripts/ui-elements/examples.charts.js for more settings.

                        </script>

                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- end: page -->
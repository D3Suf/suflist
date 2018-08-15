<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\SweetAlertAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use aayaresko\timer\Timer;
use kartik\date\DatePicker;
use frontend\controllers\SiteController;
use kartik\time\TimePicker;

$id = Yii::$app->user->id;
$model = SiteController::getTimerday($id);
$current_time = time();

//função de controlo
SiteController::addWeek();

if (!empty($model)) {
    // já deu start
    if ($model->status == 'finish' && $model->h_check == '1' && ($model->dia != date('l', $current_time))) {
        SiteController::deleteTimer($model, $id);
        //apagar dados e começar um novo dia;
    }
    if (empty($model->h_pausa)) {
        // primeiro start
        $current_time = strtotime("GMT+2"); //este GMT+2 é proveniente da hora ter sido alterada. 
        $hora_usar = $current_time - $model->h_inicio;
        $hours = date('H', $hora_usar);
        $mins = date('i', $hora_usar);
        $seconds = date('s', $hora_usar);

        if ($model->status == 'start') {
            $autostart = true;
        } else {
            $autostart = false;
        }
    } else {
        //pause
        $hora_usar = $model->h_total - 3600; //este 3600 é proveniente da hora ter sido alterada. 
        if ($model->status == 'start') {
            $current_time = strtotime("GMT+2"); //este GMT+2 é proveniente da hora ter sido alterada. 
            $autostart = true;
            $hora_usar = (($current_time - $model->h_inicio) + $model->h_total);
        } else {
            $autostart = false;
        }
        $hours = date('H', $hora_usar);
        $mins = date('i', $hora_usar);
        $seconds = date('s', $hora_usar);
    }
} else {
    $autostart = false;
    $hours = 0;
    $mins = 0;
    $seconds = 0;
}

Timer::widget([
    'options' => [
        'container' => '.timer',
        'autoStart' => $autostart,
        'seconds' => (int) $seconds,
        'minutes' => (int) $mins,
        'hours' => (int) $hours,
    ]
]);

AppAsset::register($this);
SweetAlertAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <section class="body">
            <!-- start: header -->
            <header class="header">
                <div class="logo-container">
                    <a href="<?= Url::to(['site/index']); ?>" class="logo">
                        <?= Html::img(Yii::getAlias('@web') . '/img/suflogov4small.png', ['alt' => 'Carlos Sousa Logo']); ?>
                    </a>
                    <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>

                <!-- start: search & user box -->
                <div class="header-right">
                    <ul class="notifications">
                        <li>
                            <?php
                            if (!empty($model)) {
                                if ($model->dia == date('l', $current_time)) {
                                    if ($model->status == 'finish') {
                                        echo '<p class="timerv1">' . date('H:i:s', (int) $model->h_total - 3600) . ' Finish </p>';
                                    } else {
                                        echo '<div class="timer"></div>';
                                    }
                                } else {
                                    
                                }
                            } else {
                                echo '<div class="timer"></div>';
                            }
                            ?>
                        </li>
                        <!-- start watch -->
                        <?php
                        if (!empty($model)) {
                            if ($model->dia == date('l', $current_time)) {

                                if ($model->status == 'start') {
                                    echo '<li>'
                                    . Html::beginForm(['/site/pause', 'id' => $id], 'post')
                                    . Html::submitButton(
                                            'PAUSE <i class = "fa fa-pause" aria-hidden = "true"></i>', ['class' => 'btn btn-warning btn-stop']
                                    )
                                    . Html::endForm()
                                    . '</li>';
                                    $hora_final = SiteController::getHfinalcompany();
                                    $hora_finalv1 = date('H:i', $hora_final);
                                    $hora_final = strtotime($hora_finalv1);
                                    if ($hora_final <= time()) {
                                        echo '<li>'
                                        . Html::beginForm(['/site/finish', 'id' => $id], 'post')
                                        . Html::submitButton(
                                                'FINISH <i class = "fa fa-stop" aria-hidden = "true"></i>', ['class' => 'btn btn-danger btn-stop'])
                                        . Html::endForm()
                                        . '</li>';
                                    } else {
                                        echo '<li>'
                                        . Html::beginForm(['/site/finish', 'id' => $id], 'post')
                                        . Html::submitButton(
                                                'FINISH <i class = "fa fa-stop" aria-hidden = "true"></i>', ['class' => 'btn btn-danger btn-stop', 'data' => [
                                                'confirm' => 'Confirma que quer terminar o dia antes da hora? <br/> <small> Se sim justifique.</small>',
                                                'method' => 'post',
                                            ],])
                                        . Html::endForm()
                                        . '</li>';
                                    }
                                } elseif ($model->status == 'finish') {
                                    echo '';
                                } else {
                                    echo '<li>'
                                    . Html::beginForm(['/site/start', 'id' => $id], 'post')
                                    . Html::submitButton(
                                            'START <i class = "fa fa-play" aria-hidden = "true"></i>', ['class' => 'btn btn-success btn-start']
                                    )
                                    . Html::endForm()
                                    . '</li>';
                                }
                            } else {
                                echo 'Não fechou o dia de ontem, por favor<a class="modal-with-form btn btn-link " href="#noclose">indique o motivo</a>para continuar';
                            }
                        } else {
                            echo '<li>'
                            . Html::beginForm(['/site/start', 'id' => $id], 'post')
                            . Html::submitButton(
                                    'START <i class = "fa fa-play" aria-hidden = "true"></i>', ['class' => 'btn btn-success btn-start']
                            )
                            . Html::endForm()
                            . '</li>';
                        }
                        ?>
                    </ul>
<!--                    <section class="panel">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="fa fa-caret-down"></a>
                                <a href="#" class="fa fa-times"></a>
                            </div>

                            <h2 class="panel-title">Form</h2>
                            <p class="panel-subtitle">Modal with a form and buttons.</p>
                        </header>
                        <div class="panel-body">-->




                    <span class="separator"></span>

                    <ul class="notifications">
                        <li>
                            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="badge">4</span>
                            </a>

                            <div class="dropdown-menu notification-menu">
                                <div class="notification-title">
                                    <span class="pull-right label label-default">230</span>
                                    Messages
                                </div>

                                <div class="content">
                                    <ul>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <figure class="image">
                                                    <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                                </figure>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <figure class="image">
                                                    <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                                </figure>
                                                <span class="title">Brevemente</span>
                                                <span class="message truncate">Brevemente</span>
                                        </li>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <figure class="image">
                                                    <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                                </figure>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <figure class="image">
                                                    <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                                </figure>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <hr />

                                    <div class="text-right">
                                        <a href="#" class="view-more">Brevemente</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="badge">3</span>
                            </a>

                            <div class="dropdown-menu notification-menu">
                                <div class="notification-title">
                                    <span class="pull-right label label-default">3</span>
                                    Alerts
                                </div>

                                <div class="content">
                                    <ul>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <div class="image">
                                                    <i class="fa fa-thumbs-down bg-danger"></i>
                                                </div>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <div class="image">
                                                    <i class="fa fa-lock bg-warning"></i>
                                                </div>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="clearfix">
                                                <div class="image">
                                                    <i class="fa fa-signal bg-success"></i>
                                                </div>
                                                <span class="title">Brevemente</span>
                                                <span class="message">Brevemente</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <hr />

                                    <div class="text-right">
                                        <a href="#" class="view-more">Brevemente</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <span class="separator"></span>

                    <div id="userbox" class="userbox">
                        <a href="#" data-toggle="dropdown">
                            <figure class="profile-picture">
                                <?php
                                if (!Yii::$app->user->isGuest) {
                                    if (Yii::$app->user->identity->photo == 'default-profile') {
                                        echo Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['alt' => 'default user']);
                                    } else {
                                        //foto de perfil
                                        echo '<img class="rounded img-responsive" src="http://graph.facebook.com/' . Yii::$app->user->identity->photo . '/picture?width=350&height=350" />';
                                    }
                                }
                                ?>
                            </figure>
                            <div class="profile-info" data-lock-name="<?php echo Yii::$app->user->identity->username ?>" data-lock-email="<?php echo Yii::$app->user->identity->email ?>">
                                <span class="name"><?php echo Yii::$app->user->identity->username ?></span>
                                <span class="role">
                                    <?php
                                    if (Yii::$app->user->identity->ceo == 2) {
                                        echo 'CEO';
                                    } else {
                                        echo 'Trabalhador';
                                    }
                                    ?>
                                </span>
                            </div>

                            <i class="fa custom-caret"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled">
                                <li class="divider"></li>
                                <li>
                                    <?php $username = SiteController::urlTitle(Yii::$app->user->identity->username); ?>
                                    <a role="menuitem" tabindex="-1" href="<?= Url::to(['site/view-user', 'id' => Yii::$app->user->id, 'slug' => $username]); ?>"><i class="fa fa-user"></i>Pagina de Perfil</a>
                                </li>
                                <!--                                <li>
                                                                    <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i>Bloquear Ecra</a>
                                                                </li>-->
                                <li>
                                    <?php
                                    echo Html::beginForm(['/site/logout'], 'post') . Html::submitButton(
                                            '<i class="fa fa-power-off"></i> Logout, ' . Yii::$app->user->identity->username . '', ['class' => 'btn-xs btn-link']
                                    ) . Html::endForm();
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end: search & user box -->
            </header>
            <!-- end: header -->

            <div class="inner-wrapper">
                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left">

                    <div class="sidebar-header">
                        <div class="sidebar-title">
                            Navegação
                        </div>
                        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                        </div>
                    </div>

                    <div class="nano">
                        <div class="nano-content">
                            <nav id="menu" class="nav-main" role="navigation">
                                <ul class="nav nav-main">
                                    <li class="nav-active">
                                        <a href="#">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            <span>Painel de Controlo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Url::to(['site/info']); ?>">
                                            <i class="fa fa-cloud" aria-hidden="true"></i>   
                                            <span><?php echo Yii::$app->user->identity->company ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="pull-right label label-primary">brevemente</span>
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <span>Caixa de Entrada</span>
                                        </a>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-desktop" aria-hidden="true"></i>
                                            <span>Sistema</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="<?= Url::to(['site/alert']); ?>">
                                                    Painel administrativo <small>(CEO)</small> 
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Brevemente (faltam ideias)
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    Brevemente (faltam ideias)
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                            <span>Support</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="pull-right label label-danger">alta prioridade</span>
                                            <i class="fa fa-bug" aria-hidden="true"></i>
                                            <span>Reportar Bug</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            <span>Sugestões de melhorias</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.iconsulting-group.com/" target="_blank">
                                            <i class="fa fa-external-link" aria-hidden="true"></i>
                                            <span>iConsulting Web Site <em class="not-included"></em></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                            <hr class="separator" />

                            <hr class="separator" />

                            <div class="sidebar-widget widget-stats">
                                <div class="widget-header">
                                    <h6>Company Stats</h6>
                                    <div class="widget-toggle">+</div>
                                </div>
                                <div class="widget-content">
                                    <ul>
                                        <li>
                                            <span class="stats-title">Media de H/trabalho</span>
                                            <span class="stats-complete">85%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
                                                    <span class="sr-only">85% Complete</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="stats-title">Media de Nº faltas</span>
                                            <span class="stats-complete">70%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="stats-title">Media de Nº Atrasos</span>
                                            <span class="stats-complete">2%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
                                                    <span class="sr-only">2% Complete</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </aside>

                <!-- end: sidebar -->
                <section role="main" class="content-body">






                    <?= Alert::widget() ?>
                    <?= $content ?>
                </section>
            </div>


            <aside id="sidebar-right" class="sidebar-right">
                <div class="nano">
                    <div class="nano-content">
                        <a href="#" class="mobile-close visible-xs">
                            Collapse <i class="fa fa-chevron-right"></i>
                        </a>

                        <div class="sidebar-right-wrapper">

                            <div class="sidebar-widget widget-calendar">
                                <h6>Upcoming Tasks</h6>
                                <!--                                <div data-plugin-datepicker data-plugin-skin="dark" ></div>-->
                                <?php
                                echo DatePicker::widget([
                                    'name' => 'check_issue_date',
                                    'value' => date('d-M-Y', strtotime('+2 days')),
                                    'options' => ['placeholder' => 'Select issue date ...'],
                                    'pluginOptions' => [
                                        'format' => 'dd-M-yyyy',
                                        'todayHighlight' => true
                                    ]
                                ]);
                                ?>


                                <ul>
                                    <li>
                                        <time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
                                        <span>Company Meeting</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="sidebar-widget widget-friends">
                                <h6>Team <?php echo Yii::$app->user->identity->company ?></h6>
                                <ul>
                                    <li class="status-online">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                    <li class="status-online">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                    <li class="status-online">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                    <li class="status-offline">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                    <li class="status-offline">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                    <li class="status-offline">
                                        <figure class="profile-picture">
                                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle', 'alt' => 'default user']); ?>
                                        </figure>
                                        <div class="profile-info">
                                            <span class="name">Brevemente</span>
                                            <span class="title">Brevemente</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </aside>
        </section>
        <!-- Modal Form atraso -->
        <div id="atraso" class="modal-block modal-block-primary mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Atraso, justifique ...</h2>
                </header>
                <div class="panel-body">
                    <?= Html::beginForm(['site/atraso'], 'post', ['class' => 'form-horizontal mb-lg', 'role' => 'form']); ?>
                    <!--                    <form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">-->
                    <div class="form-group mt-lg">
                        <label class="col-sm-3 control-label">Hora do checkin <br/> <small class="text-danger">não pode alterar</small></label>
                        <div class="col-sm-9">
                            <?php
                            if (!empty($model)) {
                                $x = date('H:i', (strtotime($model->data_insert)));
                            } else {
                                $x = '';
                            }
                            echo TimePicker::widget([
                                'name' => 'atraso',
                                'value' => $x,
                                'options' => [
                                    'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Justifique <br/> <small class="text-success">indique as horas que realmente entrou na empresa</small></label>
                        <div class="col-sm-9">
                            <textarea rows="5" name="motivo" class="form-control" placeholder="Escreva o aqui o motivo do atraso" required></textarea>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <button class="btn btn-default modal-dismiss">Cancelar</button>
                        </div>
                    </div>
                </footer>
                <?= Html::endForm(); ?>
            </section>
        </div>
        <!-- Modal Form fechar dia antes de hora -->
        <div id="saida" class="modal-block modal-block-primary mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Terminar o dia, antecipadamente ...</h2>
                </header>
                <div class="panel-body">
                    <?= Html::beginForm(['site/saida'], 'post', ['class' => 'form-horizontal mb-lg', 'role' => 'form']); ?>
                    <!--                    <form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">-->
                    <div class="form-group mt-lg">
                        <label class="col-sm-3 control-label">Hora do checkout <small class="text-danger">não pode alterar</small></label>
                        <div class="col-sm-9">
                            <?php
                            if (!empty($model)) {
                                $x = date('H:i', ($model->h_final));
                            } else {
                                $x = '';
                            }
                            echo TimePicker::widget([
                                'name' => 'hora_final',
                                'value' => $x,
                                'options' => [
                                    'readonly' => true,
                                ],
                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Justifique</label>
                        <div class="col-sm-9">
                            <textarea rows="5" name="motivo" class="form-control" placeholder="Escreva o aqui o motivo do atraso" required></textarea>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <button class="btn btn-default modal-dismiss">Cancelar</button>
                        </div>
                    </div>
                </footer>
                <?= Html::endForm(); ?>
            </section>
        </div>
        <!-- Modal Form fechar dia (forget) -->
        <div id="noclose" class="modal-block modal-block-primary mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Indique a hora que fechou o dia</h2>
                </header>
                <div class="panel-body">
                    <?= Html::beginForm(['site/noclose'], 'post', ['class' => 'form-horizontal mb-lg', 'role' => 'form']); ?>
                    <!--                    <form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">-->
                    <div class="form-group mt-lg">
                        <label class="col-sm-3 control-label">Hora de saida <small class="text-danger"><strong>Atenção</strong> indique <br/> a hora que saiu </small></label>
                        <div class="col-sm-9">
                            <?php
                            echo TimePicker::widget([
                                'name' => 'hora_final',
                                'value' => '17:30',
                                'pluginOptions' => [
                                    'showSeconds' => false,
                                    'showMeridian' => false,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Justifique</label>
                        <div class="col-sm-9">
                            <textarea rows="5" name="motivo" class="form-control" placeholder="Escreva o aqui o motivo pelo o qual não fechou o dia" required></textarea>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <button class="btn btn-default modal-dismiss">Cancelar</button>
                        </div>
                    </div>
                </footer>
                <?= Html::endForm(); ?>
            </section>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-start').on('click', function () {
            $.fn.timer.worker.go();
        });
        $('.btn-stop').on('click', function () {
            $.fn.timer.worker.stop();
        });
    });
</script>
<?php $this->endPage() ?>

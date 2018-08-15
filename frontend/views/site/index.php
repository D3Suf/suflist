<?php

use frontend\controllers\SiteController;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <section class="body-sign body-locked body-sign1">
        <div class="center-sign">
            <div class="panel panel-sign">
                <div class="panel-body panel-body1">
                    <form action="index.html">
                        <div class="current-user text-center">
                            <?= Html::img(Yii::getAlias('@web') . '/img/userdefault.png', ['class' => 'img-circle user-image', 'alt' => 'default user']); ?>
                            <h2 class="user-name text-dark m-none">Welcome</h2>
                            <p class="user-email m-none"></p>
                        </div>
                        <div class="form-group mb-lg">
                            <div class="input-group input-group-icon">
                                <input id="pwd" type="password" class="form-control input-lg" placeholder="Password" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <p class="mt-xs mb-none">
                                    <a href="#"></a>
                                </p>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-primary">Unlock</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

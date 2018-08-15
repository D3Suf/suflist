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
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 text-center">
            <p class="msg_setup">
                Temos <strong> três planos </strong> distintos <br/>
                <small style="font-size: 15px"> Escolha o que melhor se adapta a sua situação </small>
            </p>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    </div>

    <div class="row">
        <div class="pricing-table">
            <div class="col-md-4">
                <div class="plan">
                    <h3>Standard<span>$17</span></h3>
                    <a class="btn btn-lg btn-primary" href="#">Sign up</a>
                    <ul>
                        <li><b>3GB</b> Disk Space</li>
                        <li><b>25GB</b> Monthly Bandwidth</li>
                        <li><b>5</b> Email Accounts</li>
                        <li><b>Unlimited</b> subdomains</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan most-popular">
                    <div class="plan-ribbon-wrapper"><div class="plan-ribbon">Popular</div></div>
                    <h3>Professional<span>$29</span></h3>
                    <a class="btn btn-lg btn-primary" href="#">Sign up</a>
                    <ul>
                        <li><b>5GB</b> Disk Space</li>
                        <li><b>50GB</b> Monthly Bandwidth</li>
                        <li><b>10</b> Email Accounts</li>
                        <li><b>Unlimited</b> subdomains</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan">
                    <h3>Enterprise<span>$59</span></h3>
                    <a class="btn btn-lg btn-primary" href="#">Sign up</a>
                    <ul>
                        <li><b>10GB</b> Disk Space</li>
                        <li><b>100GB</b> Monthly Bandwidth</li>
                        <li><b>20</b> Email Accounts</li>
                        <li><b>Unlimited</b> subdomains</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 text-center">
            <?= Html::beginForm(['site/promocode'], 'post', ['role' => 'form']); ?>
            <div class="form-group mb-lg">
                <div class="clearfix">
                    <label class="pull-left" style="color:black"> Utilizar código promocional </label>
                </div>
                <div class="input-group input-group-icon">
                    <input name="pwd" id="pwd" type="password" class="form-control input-lg" />
                    <span class="input-group-addon">
                        <span class="icon icon-lg">
                            <i class="fa fa-lock"></i>
                        </span>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary hidden-xs">Entrar</button>
                </div>
            </div>

            <?= Html::endForm(); ?>
        </div>

    </div>
</div>
<!-- end: page -->
<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="fixed">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body onload="$('#loader').hide();">
        <?php $this->beginBody() ?>
        <div class='col-md-4 text-center' id="loader"><img src="<?= Url::to('@web/img/loader123.gif') ?>" alt="Loading"/>
            <p class='black'>Estamos quase prontos ...</p>
        </div>



        <?= Alert::widget() ?>
        <?= $content ?>


        <?php $this->endBody() ?>
        <script type="text/javascript">
            $(document).ready(function () {
                //When clicking on a button, it shows the loader
                $('.btn-loading').on('click', function () {
                    $('#loader').show();
                });
            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>

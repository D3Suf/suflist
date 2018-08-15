<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/site2.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light',
        'js/vendor/morris/morris.css',
    ];
    public $js = [
        'js/vendor/modernizr/modernizr.js',
//        'js/vendor/jquery/jquery.js',
        'js/vendor/jquery-browser-mobile/jquery.browser.mobile.js',
        'js/vendor/bootstrap/js/bootstrap.js',
        'js/vendor/nanoscroller/nanoscroller.js',
        'js/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'js/vendor/magnific-popup/magnific-popup.js',
        'js/vendor/jquery-placeholder/jquery.placeholder.js',
        //<!-- Specific Page Vendor -->
        'js/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js',
        'js/vendor/flot/jquery.flot.js',
        'js/vendor/flot-tooltip/jquery.flot.tooltip.js',
        'js/vendor/flot/jquery.flot.pie.js',
        'js/vendor/flot/jquery.flot.categories.js',
        'js/vendor/flot/jquery.flot.resize.js',
        'js/vendor/jquery-sparkline/jquery.sparkline.js',
        'js/vendor/raphael/raphael.js',
        'js/vendor/morris/morris.js',
        'js/vendor/gauge/gauge.js',
        'js/vendor/snap-svg/snap.svg.js',
        'js/vendor/liquid-meter/liquid.meter.js',
        //        'js/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js',
//////////////////////////////////////////////		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
        'js/vendor/bootstrap-multiselect/bootstrap-multiselect.js',
//////////////////////////////////////////		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
////////////////////////////////////////		<script src="assets/vendor/flot/jquery.flot.js"></script>
//////////////////////////////////////		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
////////////////////////////////////		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
//////////////////////////////////		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
////////////////////////////////		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
//////////////////////////////		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
////////////////////////////		<script src="assets/vendor/raphael/raphael.js"></script>
//////////////////////////		<script src="assets/vendor/morris/morris.js"></script>
////////////////////////		<script src="assets/vendor/gauge/gauge.js"></script>
//////////////////////		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
////////////////////		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
//////////////////		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
////////////////		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
//////////////		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
////////////		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
//////////		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
////////		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
//////		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
////		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
//		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
//		<!-- Theme Base, Components and Settings -->
        'js/javascripts/theme.js',
        'js/javascripts/theme.init.js',
//		<!-- Theme Custom -->
        'js/javascripts/theme.custom.js',
//		<!-- Theme Initialization Files -->
        'js/javascripts/dashboard/examples.dashboard.js',
        'js/javascripts/ui-elements/examples.charts.js',
        'js/javascripts/ui-elements/examples.modals.js',
        'js/stopwatch.js',
        'js/yii_overrides.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}

<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'fonts/proxima/stylesheet.css',
        'css/font-awesome.min.css',
        'slick/slick.css',
        'slick/slick-theme.css',
    ];
    public $js = [
        'js/main.js',
        'slick/slick.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}

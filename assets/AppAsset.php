<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        "front/css/bootstrap.min.css",
        "front/css/LineIcons.3.0.css",
        "front/css/tiny-slider.css",
        "front/css/glightbox.min.css",
        "front/css/main.css",
        "assets/bootstrap-icons/bootstrap-icons.css",
    ];
    public $js = [
        'js/catalog.js',
        'js/toast.js',
        "front/js/tiny-slider.js",
        "front/js/glightbox.min.js",
        "front/js/other.js",
        "front/js/main.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}

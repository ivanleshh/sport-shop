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
class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "/admin-lte-dist/css/admin/index.css",
        "/admin-lte-dist/css/admin/overlayscrollbars.min.css",
        "/admin-lte-dist/css/admin/bootstrap-icons.min.css",
        "/admin-lte-dist/css/adminlte.css",
        "/admin-lte-dist/css/admin/apexcharts.css",
        "/admin-lte-dist/css/admin/jsvectormap.min.css",
    ];
    public $js = [
        "/admin-lte-dist/js/admin/overlayscrollbars.browser.es6.min.js",
        "/admin-lte-dist/js/admin/popper.min.js",
        "/admin-lte-dist/js/admin/bootstrap.min.js",
        "/admin-lte-dist/js/adminlte.js",
        "/admin-lte-dist/js/admin/Sortable.min.js",
        "/admin-lte-dist/js/admin/jsvectormap.min.js",
        "/admin-lte-dist/js/admin/world.js",
        "/admin-lte-dist/js/other-scripts.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}

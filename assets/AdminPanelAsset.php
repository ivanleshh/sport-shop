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
class AdminPanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/style.css",
        "front/css/LineIcons.3.0.css",
        "assets/bootstrap-icons/bootstrap-icons.css",
        "admin-panel-dist/assets/vendors/simple-line-icons/css/simple-line-icons.css",
        "admin-panel-dist/assets/vendors/flag-icon-css/css/flag-icons.min.css",
        "admin-panel-dist/assets/css/vertical-light-layout/style.css",
        "admin-panel-dist/assets/css/login/admin-login.css",
    ];
    public $js = [
        "admin-panel-dist/assets/js/jquery.cookie.js",
        "admin-panel-dist/assets/js/off-canvas.js",
        "admin-panel-dist/assets/js/hoverable-collapse.js",
        "admin-panel-dist/assets/js/misc.js",
        "admin-panel-dist/assets/js/settings.js",
        "admin-panel-dist/assets/js/todolist.js",
        "js/toast.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}

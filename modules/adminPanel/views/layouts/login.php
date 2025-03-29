<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminPanelAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Widget;

AdminPanelAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>


<body class="admin-login-body h-100">
    <?php $this->beginBody() ?>
    <section class="p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="login border-light-subtle shadow-sm rounded-4">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </section>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
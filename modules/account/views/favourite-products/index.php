<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Личный кабинет', 'url' => ['/personal']],
    'Избранное',
];
\yii\web\YiiAsset::register($this);
?>
<div class="category-view hero-content">

    <?php Pjax::begin([
        'id' => 'favourite-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <?= Alert::widget() ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'product',
        'layout' =>
        '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="catalog-items d-flex flex-wrap gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
    ]) ?>

    <?php Pjax::end(); ?>
</div>

<?= $this->registerJsFile('/js/favourite.js', ['depends' => JqueryAsset::class]); ?>
<?php

use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\PjaxAsset;

PjaxAsset::register($this);

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    'Управление Категориями',
];
?>
<div class="category-index hero-content">

    <?= Alert::widget() ?>

    <?php Pjax::begin([
        'id' => 'category-index-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-xl-8">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
        <div class="col-12 col-xl-4 d-flex gap-3 flex-wrap justify-content-end mt-3 mt-sm-0">
            <span class="text-nowrap">Сортировать по:</span>
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/admin-panel/category'], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-sm-6 col-lg-6 col-xl-4 col-xxl-3'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' =>
        '<div class="text-center mt-3">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="text-center mt-3">{pager}</div>',
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end() ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-category.js', ['depends' => JqueryAsset::class]) ?>
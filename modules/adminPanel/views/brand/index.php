<?php

use app\models\Brand;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\BrandSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    'Управление брендами',
];
?>
<div class="brand-index">

    <p class="my-4">
        <?= Html::a('Добавить бренд', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-xl-8">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
        
        <div class="col-12 col-xl-4 d-flex gap-3 justify-content-end flex-wrap mt-3 mt-sm-0">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/admin-panel/brand'], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
    </div>

    <?php Pjax::begin([
        'id' => 'brand-index-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-sm-6 col-lg-6 col-xl-4 col-xxl-3'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' =>
        '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end() ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-brand.js', ['depends' => JqueryAsset::class]) ?>

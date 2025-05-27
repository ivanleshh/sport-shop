<?php

use app\models\Brand;
use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
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
<div class="brand-index hero-content">

    <?= Alert::widget() ?>

    <?php Pjax::begin([
        'id' => 'brand-index-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="row justify-content-between align-items-center gy-3 gx-3">
        <div class="col-12 col-xl-7">
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

<?php
Modal::begin([
    'id' => 'brand-modal',
    'title' => 'Редактирование производителя',
    'size' => 'modal-md',
]);
echo $this->render('_form', ['model' => $model]) ?>
<?php Modal::end();
$this->registerJsFile('/js/brand-create-update.js', ['depends' => JqueryAsset::class]);
?>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-brand.js', ['depends' => JqueryAsset::class]) ?>
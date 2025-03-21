<?php

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

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'category-index-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex gap-3 flex-wrap my-2">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/admin-panel/category'], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
        <div class="d-flex">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-10'],
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

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-category.js', ['depends' => JqueryAsset::class]) ?>
<?php

use app\models\Product;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\VarDumper;
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

    <?php if ($dataProvider->models) : ?>

        <?php Pjax::begin([
            'id' => 'favourite-pjax',
            'enablePushState' => false,
            'timeout' => 5000,
            'enableReplaceState' => false,
        ]); ?>

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

    <?php else : ?>
        <div class="row position-relative justify-content-center text-center">
            <div class="position-absolute d-flex align-items-center bg-warning rounded-4 col-11 col-md-8 col-lg-6 col-xl-5 p-2 bottom-0 fs-6">
                <div class="text-danger fs-1">
                    <i class="bi bi-exclamation-lg"></i>
                </div>
                <span class="text-dark">Вы ещё не добавили товары в избранное. Это можно сделать в
                    <a class="text-uppercase fw-semibold text-danger" href="/catalog">каталоге</a>
                </span>
            </div>
            <div class="col-10 col-sm-8 col-md-6 col-lg-4 mb-5 mb-sm-0">
                <?= Html::img(Product::NOTHING_FIND, ['class' => 'rounded-circle']) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->registerJsFile('/js/favouriteCompare.js', ['depends' => JqueryAsset::class]); ?>
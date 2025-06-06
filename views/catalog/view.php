<?php

use app\models\Category;
use app\models\Product;
use app\widgets\Alert;
use coderius\swiperslider\SwiperSlider;
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
    ['label' => 'Каталог', 'url' => ['/catalog']],
];

if (isset($model->parent_id)) {
    array_map(function ($title) {
        $this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['view', 'id' => Category::getIdByTitle($title)]];
    }, array_reverse($model->getParentRecursive()));
}

$this->params['breadcrumbs'][] = $model->title;

\yii\web\YiiAsset::register($this);
?>
<div class="category-view hero-content">

    <?php if (!empty($model->children)): ?>
        <div class="category-view-slider mb-3">
            <?= \coderius\swiperslider\SwiperSlider::widget([
                'showScrollbar' => false,
                'showPagination' => false,
                'slides' => array_map(fn($child) => $this->render(
                    'category',
                    ['model' => $child, 'noChild' => true]
                ), $model->children),
                'clientOptions' => [
                    'loop' => false,
                    'navigation' => false,
                    'autoplay' => [
                        'delay' => 3000,
                        'disableOnInteraction' => false,
                    ],
                    'breakpoints' => [
                        0 => ['slidesPerView' => 1.5],
                        576 => ['slidesPerView' => 2.5,],
                        768 => ['slidesPerView' => 3.5],
                        992 => ['slidesPerView' => 4.5],
                        1200 => ['slidesPerView' => 5.5],
                        1400 => ['slidesPerView' => 6.5],
                    ],
                    'spaceBetween' => 10,
                ],
                'options' => [
                    'styles' => [
                        \coderius\swiperslider\SwiperSlider::SLIDE => ["height" => "75%"],
                        \coderius\swiperslider\SwiperSlider::WRAPPER => ["height" => "50px"],
                    ],
                ],

            ]); ?>
        </div>
    <?php endif; ?>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]);
    ?>

    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-lg-7 col-xl-8">
            <?= $this->render('_search', [
                'model' => $searchModel,
                'brands' => $brands,
            ]) ?>
        </div>
        <div class="col-12 col-lg-5 col-xl-4 d-flex gap-3 justify-content-end flex-wrap mt-2 mt-lg-0">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('price', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/catalog/view', 'id' => $model->id], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
    </div>

    <?php if ($dataProvider->models) : ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model) {
                return $this->render('product', [
                    'model' => $model,
                    'pjx' => '#catalog-pjax'
                ]);
            },
            'layout' =>
            '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="catalog-items d-flex justify-content-center justify-content-xl-start flex-wrap gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
        ]) ?>

    <?php else : ?>
        <div class="row position-relative justify-content-center text-center my-4">
            <div class="position-absolute d-flex align-items-center bg-warning rounded-4 col-11 col-md-8 col-lg-6 col-xl-4 p-2 bottom-0 fs-6">
                <div class="text-danger fs-1">
                    <i class="bi bi-exclamation-lg"></i>
                </div>
                <span class="text-dark">Товары по данному запросу не найдены!
                </span>
            </div>
            <div class="col-10 col-sm-8 col-md-6 col-lg-4 col-xl-3 mb-5 mb-sm-0">
                <?= Html::img(Product::NOTHING_FIND, ['class' => 'rounded-circle']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php Pjax::end(); ?>

    <p><?= $model->description ?></p>

</div>

<?= $this->registerJsFile('/js/filter-catalog.js', ['depends' => JqueryAsset::class]); ?>
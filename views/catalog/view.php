<?php

use app\models\Category;
use app\widgets\Alert;
use coderius\swiperslider\SwiperSlider;
use yii\helpers\Html;
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

    <!-- <?php if (!empty($model->children)): ?>
        <div class="d-flex flex-wrap gap-3 mb-3">
            <?php foreach ($model->children as $child): ?>
                <?= $this->render('category', ['model' => $child, 'noChild' => true]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?> -->

    <?php if (!empty($model->children)): ?>
        <?= \coderius\swiperslider\SwiperSlider::widget([
            'showScrollbar' => false,
            'showPagination' => false,
            'slides' => array_map(fn($child) => $this->render('category', ['model' => $child, 'noChild' => true]), $model->children),
            'clientOptions' => [
                'navigation' => false,
                'autoplay' => [
                    'delay' => 3000,
                    'disableOnInteraction' => false,
                ],
                'breakpoints' => [
                    0 => [
                        'slidesPerView' => 1.5,
                    ],
                    576 => [
                        'slidesPerView' => 2.5,
                    ],
                    768 => [
                        'slidesPerView' => 3.5,
                    ],
                    992 => [
                        'slidesPerView' => 4.5,
                    ],
                    1200 => [
                        'slidesPerView' => 5.5,
                    ],
                    1400 => [
                        'slidesPerView' => 6.5,
                    ],
                ],
                'slidesPerView' => 6,
                'spaceBetween' => 10,
                // 'centeredSlides' => true,
            ],
            'options' => [
                'styles' => [
                    \coderius\swiperslider\SwiperSlider::CONTAINER => ["height" => "60px"],
                ],
            ],

        ]); ?>
    <?php endif; ?>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="row justify-content-between align-items-center my-4">
        <div class="col-12 col-lg-6">
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
        <div class="col-12 col-lg-6 d-flex gap-3 justify-content-end flex-wrap mt-2 mt-lg-0">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('price', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/catalog/view', 'id' => $model->id], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
    </div>


    <?= Alert::widget() ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'product',
        'layout' =>
        '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="catalog-items d-flex justify-content-center justify-content-xl-start flex-wrap gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
    ]) ?>

    <?php Pjax::end(); ?>

    <p class="mt-5"><?= $model->description ?></p>

</div>

<?= $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]); ?>
<?= $this->registerJsFile('/js/filter-catalog.js', ['depends' => JqueryAsset::class]); ?>
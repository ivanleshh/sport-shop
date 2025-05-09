<?php

use app\models\CompareProducts;
use app\models\Product;
use app\widgets\Alert;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\CompareProductsSearch $searchModel */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Личный кабинет', 'url' => ['/personal']],
    'Сравнение товаров',
];

?>

<div class="toast-container position-fixed top-0 end-0 px-4"></div>

<div class="compare-products-index hero-content">

    <?php if ($groupedProducts) : ?>

        <?php Pjax::begin([
            'id' => 'compare-pjax',
            'enablePushState' => false,
            'timeout' => 5000,
            'enableReplaceState' => false,
        ]); ?>

        <div class="toast-data position-fixed top-0 end-0 px-4"
            data-bg-color="<?= Yii::$app->session->get('bg_color') ?>" data-text="<?= Yii::$app->session->get('text') ?>"></div>

        <?php if (Yii::$app->session->get('bg_color') !== null) {
            Yii::$app->session->remove('bg_color');
            Yii::$app->session->remove('text');
        } ?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($categories as $index => $category): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $index == 0 ? 'show active' : '' ?>" id="category-<?= $category->id ?>" data-bs-toggle="tab" data-bs-target="#content-<?= $category->id ?>" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><?= $category->title ?></button>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($categories as $index => $category): ?>
                <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>" id="content-<?= $category->id ?>" role="tabpanel" aria-labelledby="home-tab">
                    <div class="d-flex overflow-auto flex-column w-100 overflow-scroll">
                        <?php $products = $groupedProducts[$category->id]; ?>

                        <?= ListView::widget([
                            'dataProvider' => new ArrayDataProvider([
                                'allModels' => $products
                            ]),
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => 'product',
                            'layout' =>
                            '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="d-flex ms-2 gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
                        ]) ?>

                        <div class="compare-wrapper">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th class="table-active col-1">Название</th>
                                        <?php foreach ($products as $once): ?>
                                            <th class="table-active"><?= Html::encode($once->product->title) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr>
                                        <td>Цена</td>
                                        <?php foreach ($products as $once): ?>
                                            <td><?= Html::encode($once->product->price) ?> ₽</td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>Категория</td>
                                        <?php foreach ($products as $once): ?>
                                            <td><?= Html::encode($once->product->category->title) ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td>Производитель</td>
                                        <?php foreach ($products as $once): ?>
                                            <td><?= Html::encode($once->product->brand->title) ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">В наличии (единиц)</td>
                                        <?php foreach ($products as $once): ?>
                                            <td><?= Html::encode($once->product->count) ?></td>
                                        <?php endforeach; ?>
                                    </tr>

                                    <?php
                                    $uniqueProperties = [];
                                    foreach ($products as $compareProduct) {
                                        if (isset($properties[$compareProduct->product_id])) {
                                            $uniqueProperties = array_merge($uniqueProperties, array_keys($properties[$compareProduct->product_id]));
                                        }
                                    }
                                    $uniqueProperties = array_unique($uniqueProperties);
                                    ?>

                                    <?php foreach ($uniqueProperties as $propertyTitle): ?>
                                        <tr>
                                            <td><?= Html::encode($propertyTitle) ?></td>
                                            <?php foreach ($products as $compareProduct): ?>
                                                <td>
                                                    <?= Html::encode($properties[$compareProduct->product_id][$propertyTitle] ?? '-') ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php Pjax::end(); ?>

    <?php else : ?>
        <div class="row position-relative justify-content-center text-center">
            <div class="position-absolute d-flex align-items-center bg-warning rounded-4 col-11 col-md-8 col-lg-6 col-xl-5 p-2 bottom-0 fs-6">
                <div class="text-danger fs-1">
                    <i class="bi bi-exclamation-lg"></i>
                </div>
                <span class="text-dark">Вы ещё не добавили товары в сравнение. Это можно сделать в
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
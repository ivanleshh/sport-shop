<?php

use app\models\CompareProducts;
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

<div class="compare-products-index hero-content">

    <?php Pjax::begin([
        'id' => 'compare-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <?= Alert::widget() ?>

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
                <div class="d-flex flex-column">
                    <?php $products = $groupedProducts[$category->id]; ?>

                    <?= ListView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $products
                        ]),
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => 'product',
                        'layout' =>
                        '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="catalog-items d-flex flex-wrap gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
                    ]) ?>

                    <div class="compare-wrapper">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="table-active col-1">Название</th>
                                    <?php foreach ($products as $once): ?>
                                        <th class="text-nowrap table-active"><?= Html::encode($once->product->title) ?></th>
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

</div>

<?= $this->registerJsFile('/js/favouriteCompare.js', ['depends' => JqueryAsset::class]); ?>
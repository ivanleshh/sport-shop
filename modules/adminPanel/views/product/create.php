<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Управление товарами', 'url' => ['/admin-panel/product']],
    'Создание товара',
];
?>
<div class="product-create hero-content">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Категории', 'url' => ['/admin-panel/product']],
    ['label' => $model->title, 'url' => ['view', 'id' => $model->id]],
    "Изменение категории",
];
?>
<div class="category-update hero-content">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'categoryProperties' => $categoryProperties,
        'properties' => $properties,
    ]) ?>

</div>

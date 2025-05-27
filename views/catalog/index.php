<?php

use yii\widgets\ListView;
/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Каталог',
];
?>
<div class="hero-content category-index">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'category',
        'layout' => '<div class="d-flex flex-column gap-3">{items}</div>'
    ]) ?>
</div>

<?= \app\widgets\RecentlyViewed::widget() ?>

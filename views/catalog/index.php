<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site/index'], 'icon' => 'bi bi-house-fill mx-2'],
    'Каталог',
];
?>
<div class="category-index">

    <?php Pjax::begin(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'category',
        'layout' => '<div class="d-flex flex-wrap gap-3 my-3">{items}</div>'
    ]) ?>

    <?php Pjax::end(); ?>

</div>

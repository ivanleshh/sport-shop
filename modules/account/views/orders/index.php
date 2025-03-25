<?php

use app\models\Orders;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\account\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои заказы';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/personal']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Личный кабинет', 'url' => ['/personal']],
    'Мои заказы',
];
?>
<div class="hero-content orders-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin(); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-xxl-6'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' => 
            '<div class="d-flex mt-3">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="d-flex mt-3">{pager}</div>',
        'itemView' => 'order',
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php

use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Личный кабинет',
];
?>

<div class="user-index">

    <?php Pjax::begin([
        'id' => 'personal-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]);
    ?>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <div class="hero-content col-12">
                <div class="d-flex flex-wrap justify-content-between gap-2 border border-2 border-muted rounded-3 text-dark fs-6 p-3">
                    <div>
                        <i class='bi bi-bag-heart-fill me-2'></i>
                        <span class="fw-semibold">Избранное</span>
                    </div>
                    <div>
                        (Товаров добавлено: <?= $countFavourites ?> шт.)
                    </div>
                    <div>
                        <?= Html::a('Посмотреть', ['/personal/favourite-products']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="hero-content col-12">
                <div class="d-flex flex-wrap justify-content-between gap-2 border border-2 border-muted rounded-3 text-dark fs-6 p-3">
                    <div>
                        <i class="bi bi-bar-chart-line me-2"></i>
                        <span class="fw-semibold">Сравнение</span>
                    </div>
                    <div>
                        (Товаров добавлено: <?= $countCompare ?> шт.)
                    </div>
                    <div>
                        <?= Html::a('Посмотреть', ['/personal/compare-products']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="hero-content">
                <div class="accordion" id="accordionOrders">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personal-orders" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                <i class='bi bi-truck me-2 text-dark'></i>
                                <span class="text-dark fw-semibold">История заказов</span>
                            </button>
                        </h2>
                        <div id="personal-orders" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <?php if (isset($orders)) {
                                    foreach ($orders as $order) {
                                        $is_payed = $order->is_payed;
                                        echo "<div class='order-item mb-2 d-flex gap-5 align-items-center justify-content-between border-bottom pb-2'>
                                    <div>
                                        <span class='fw-bold'>Заказ № $order->id</span>
                                        <span>от " . Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') . "</span>
                                        <div class='text-" . $order->status->bg_color . "'>" . $order->status->title . "</div>
                                        <div class=" . ($is_payed ? 'text-success' : 'text-danger') . ">" . ($is_payed ? 'Оплачен' : 'Не оплачен') . "</div>
                                    </div>
                                    <div class='text-nowrap text-center'>
                                        <div class='text-muted'>Товаров: " . $order->product_amount . "</div>
                                        <span class='fw-bold fs-6'>$order->total_amount</span>
                                        ₽
                                        <div>" . Html::a('Перейти', ['/personal/orders/view', 'id' => $order->id]) . "</div>
                                    </div>
                                </div>";
                                    }
                                } ?>
                                <div>
                                    <?= Html::a('Посмотреть все', ['/personal/orders']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 h-100">
            <div class="hero-content">
                <div class="accordion" id="accordionInfo">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personal-info" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                <i class="bi bi-file-earmark-person-fill text-dark me-2"></i>
                                <span class="text-dark fw-semibold">Персональные данные</span>
                            </button>
                        </h2>
                        <div id="personal-info" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="user-personal-form">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'name',
                                            'surname',
                                            'login',
                                            'email:email',
                                            [
                                                'attribute' => 'password',
                                                'value' => '************'
                                            ]
                                        ],
                                    ]) ?>
                                    <div class="d-flex gap-2">
                                        <?= Html::a('Изменить персональные данные', ['change-personal', 'id' => $model->id], ['class' => 'btn btn-primary btn-change-personal']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php Pjax::end(); ?>
</div>

<?= \app\widgets\RecentlyViewed::widget() ?>

<?php
if ($dataProvider->count) {
    Modal::begin([
        'id' => 'change-personal-modal',
        'title' => 'Изменение персональных данных',
        'size' => 'modal-md',
    ]);
    echo $this->render('update', compact('model'));
    Modal::end();
    $this->registerJsFile('/js/change-personal.js', ['depends' => JqueryAsset::class]);
}
?>
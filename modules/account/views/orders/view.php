<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['cart-data'] = $dataProvider && $dataProvider->totalCount;
$this->title = 'Заказ № ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/personal']];
$this->params['breadcrumbs'][] = ['label' => 'Мои заказы', 'url' => ['/personal/orders']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['breadcrumbs'] = [
    ['label' => 'Личный кабинет', 'url' => ['/personal'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Мои заказы', 'url' => ['/personal/orders']],
    "Заказ № $model->id",
];

?>

<div class="cart-index hero-content">
    <div class="row">

        <div class="col-12 col-md-6 order-1 order-md-2">
            <div class="row gy-3">
                <div class="col-12">
                    <?php Pjax::begin([
                        'id' => 'admin-orders-view-pjax',
                        'enablePushState' => false,
                        'timeout' => 5000,
                    ]); ?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'phone',
                            [
                                'attribute' => 'status_id',
                                'value' => $model->status->title,
                            ],
                            [
                                'attribute' => 'new_date_delivery',
                                'value' => Yii::$app->formatter->asDatetime($model?->new_date_delivery, 'php:d.m.Y'),
                                'visible' => (bool)$model?->new_date_delivery,
                                'captionOptions' => [
                                    'class' => 'text-wrap'
                                ]
                            ],
                            [
                                'attribute' => 'delay_reason',
                                'value' => $model?->delay_reason,
                                'visible' => (bool)$model?->delay_reason,
                                'captionOptions' => [
                                    'class' => 'text-wrap'
                                ]
                            ],
                            [
                                'attribute' => 'pick_up_id',
                                'value' => $model->pickUp?->address,
                                'visible' => (bool)$model->pickUp?->address,
                                'contentOptions' => [
                                    'class' => 'text-wrap'
                                ],
                                'captionOptions' => [
                                    'class' => 'text-wrap'
                                ]
                            ],
                            [
                                'attribute' => 'email',
                                'value' => $model->email,
                                'contentOptions' => [
                                    'class' => 'text-wrap'
                                ],
                            ],
                            [
                                'attribute' => 'date_delivery',
                                'value' => Yii::$app->formatter->asDatetime($model?->date_delivery, 'php:d.m.Y'),
                                'visible' => (bool)$model?->date_delivery,
                            ],
                            [
                                'attribute' => 'time_delivery',
                                'value' => Yii::$app->formatter->asDatetime($model?->time_delivery, 'php:H:i'),
                                'visible' => (bool)$model?->time_delivery,
                            ],
                            [
                                'attribute' => 'address',
                                'value' => $model->address,
                                'visible' => (bool)$model->address,
                            ],
                            [
                                'attribute' => 'comment',
                                'value' => $model?->comment,
                                'visible' => (bool)$model?->comment,
                            ],
                            [
                                'attribute' => 'type_pay_id',
                                'value' => $model->typePay->title,
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i'),
                                'captionOptions' => [
                                    'class' => 'text-wrap'
                                ]
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i'),
                                'captionOptions' => [
                                    'class' => 'text-wrap'
                                ]
                            ],
                        ],
                    ]) ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 order-3 order-md-1">
            <div class="d-flex gap-3 align-items-center justify-content-between py-2 my-3 border-top border-bottom flex-wrap">
                <div>
                    <a class="text-decoration-none text-danger" href="/personal/orders">
                        <i class="bi bi-arrow-return-left"></i>
                        Вернуться к заказам
                    </a>
                </div>
                <div class="d-flex gap-3 flex-wrap justify-content-end w-100 text-dark">
                    <div>Количество товаров: <span class="fw-bold fs-5"><?= $model->product_amount ?></span></div>
                    <div>Общая сумма: <span class="fw-bold fs-5"><?= $model->total_amount ?> ₽</span></div>
                </div>
            </div>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => 'order-item',
                'pager' => [
                    'class' => LinkPager::class
                ],
                'layout' => "<div class='d-flex flex-column gap-3'>{items}</div>\n<div class='d-flex justify-content-end'>{pager}</div>"
            ]) ?>
        </div>
    </div>
</div>
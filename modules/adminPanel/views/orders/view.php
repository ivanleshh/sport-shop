<?php

use app\models\Cart;
use app\models\Status;
use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Модерация заказов', 'url' => ['/admin-panel']],
    "Заказ № $model->id",
];
?>
<div class="cart-index hero-content">
    <div class="row">

        <div class="col-12 col-md-6 order-1 order-md-2">

            <?php Pjax::begin([
                'id' => 'admin-orders-view-pjax',
                'enablePushState' => false,
                'timeout' => 5000,
            ]); ?>

            <?php if (Yii::$app->session->hasFlash('order-delay')) {
                Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('order-delay'));
                Yii::$app->session->removeFlash('order-delay');
                echo Alert::widget();
            }
            ?>

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

            <div class="row gy-3 mt-2 mb-3">
                <?php if ($model->status->id == Status::getStatusId('Новый')) {
                    echo "<div class='col-12 col-sm-6 col-md-12 col-xl-6'>" . Html::a('Принять в работу', ['work', 'id' => $model->id], [
                        'class' => 'btn btn-warning w-100',
                        'data' => [
                            'confirm' => 'Подтвердите действие',
                            'method' => 'post',
                        ],
                    ]) . "</div>";
                } else if ($model->status_id == Status::getStatusId('В пути') || $model->status_id == Status::getStatusId('Доставка перенесена')) {
                    if (is_null($model->address) && $model->status_id == Status::getStatusId('В пути')) {
                        echo "<div class='col-12 col-sm-6 col-md-12 col-xl-6'>" . Html::a('Перенести доставку', ['delay', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-delay w-100',
                        ]) . "</div>";
                    }
                    echo "<div class='col-12 col-sm-6 col-md-12 col-xl-6'>" . Html::a('Подтвердить получение', ['success', 'id' => $model->id], [
                        'class' => 'btn btn-success w-100',
                        'data' => [
                            'confirm' => 'Подтвердите действие',
                            'method' => 'post',
                        ],
                    ]) . "</div>";
                }
                ?>
            </div>

        </div>

        <div class="col-12 col-md-6 order-3 order-md-1">
            <div class="d-flex gap-2 align-items-end flex-column py-2 mb-3 border-top border-bottom">
                <div>Количество товаров в заказе: <span class="fw-bold fs-5"><?= $model->product_amount ?></span></div>
                <div>Общая сумма заказа: <span class="fw-bold fs-5"><?= $model->total_amount ?> ₽</span></div>
                <a class="text-decoration-none align-self-start" href="/admin-panel/orders"><- Вернуться к заказам</a>
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

<?php
if ($dataProviderr->count) {
    Modal::begin([
        'id' => 'orders-view-delay-modal',
        'title' => 'Уведомление о задержке доставки',
        'size' => 'modal-md',
    ]);
    echo $this->render('delay', compact('model_delay'));
    Modal::end();
    $this->registerJsFile('/js/orders-view-delay.js', ['depends' => JqueryAsset::class]);
}
?>
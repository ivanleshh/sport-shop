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

?>
<div class="cart-index">
    <h3>Заказ № <?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y (H:i)') ?></h3>
    <div class="order-details d-flex gap-4 mt-2">
        <div class="order-details-items border rounded-3 px-4 py-3 w-50">
            <h3 class="mb-3">Состав заказа</h3>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => 'order-item',
                'pager' => [
                    'class' => LinkPager::class
                ],
                'layout' => "<div class='d-flex flex-column gap-3 my-2'>{items}</div>\n<div class='d-flex justify-content-end'>{pager}</div>"
            ]) ?>

            <div class="d-flex gap-1 align-items-end flex-column border-bottom py-2">
                <div>Количество товаров в заказе: <span class="fw-bold fs-5"><?= $model->product_amount ?></span></div>
                <div>Общая сумма заказа: <span class="fw-bold fs-5"><?= $model->total_amount ?> ₽</span></div>
                <a class="text-decoration-none align-self-start" href="/admin-panel"><- Вернуться к заказам</a>
            </div>
        </div>
        <div class="order-details-info border rounded-3 px-4 py-3 w-50">
            <h3 class="mb-3">Информация о заказе</h3>

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
                    ],
                    [
                        'attribute' => 'delay_reason',
                        'value' => $model?->delay_reason,
                        'visible' => (bool)$model?->delay_reason,
                    ],
                    [
                        'attribute' => 'pick_up_id',
                        'value' => $model->pickUp?->address,
                        'visible' => (bool)$model->pickUp?->address,
                    ],
                    'email:email',
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
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i'),
                    ],
                ],
            ]) ?>
            <div class="d-flex flex-column gap-3 justify-content-center">
                <?php if ($model->status->id == Status::getStatusId('Новый')) {
                    echo Html::a('Принять в работу', ['work', 'id' => $model->id], [
                        'class' => 'btn btn-outline-warning',
                        'data' => [
                            'confirm' => 'Подтвердите действие',
                            'method' => 'post',
                        ],
                    ]);
                } else if ($model->status_id == Status::getStatusId('В пути') || $model->status_id == Status::getStatusId('Доставка перенесена')) {
                    if (is_null($model->address) && $model->status_id == Status::getStatusId('В пути')) {
                        echo Html::a('Перенести доставку', ['delay', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger btn-delay',
                        ]);
                    }
                    echo Html::a('Подтвердить получение', ['success', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success',
                        'data' => [
                            'confirm' => 'Подтвердите действие',
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
            </div>

            <?php Pjax::end(); ?>
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
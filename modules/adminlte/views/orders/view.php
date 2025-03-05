<?php

use app\models\Cart;
use app\models\Status;
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
                <a class="text-decoration-none align-self-start" href="/"><- Вернуться к покупкам</a>
            </div>
        </div>
        <div class="order-details-info border rounded-3 px-4 py-3 w-50">
            <h3 class="mb-3">Информация о заказе</h3>

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
                        'attribute' => 'pick_up_id',
                        'value' => $model->pickUp?->address,
                        'visible' => (bool)$model->pickUp?->address,
                    ],
                    'email:email',
                    [
                        'attribute' => 'date_delivery',
                        'value' => $model?->date_delivery,
                        'visible' => (bool)$model?->date_delivery,
                    ],
                    [
                        'attribute' => 'delay_reason',
                        'value' => $model?->delay_reason,
                        'visible' => (bool)$model?->delay_reason,
                    ],
                    [
                        'attribute' => 'new_date_delivery',
                        'value' => $model?->new_date_delivery,
                        'visible' => (bool)$model?->new_date_delivery,
                    ],
                    [
                        'attribute' => 'time_delivery',
                        'value' => $model?->time_delivery,
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
                    echo Html::a('Принять', ['work'], ['class' => 'btn btn-outline-warning']);
                } else {
                    if (is_null($model->address)) {
                        echo Html::a('Перенести доставку', ['delay'], ['class' => 'btn btn-outline-danger btn-delay']);
                    }
                    echo Html::a('Подтвердить получение', ['success'], ['class' => 'btn btn-outline-success']);
                }
                ?>
            </div>
        </div>
    </div>
</div>
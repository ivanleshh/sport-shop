<?php

use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card h-100 rounded-4 border">
  <div class="border-bottom d-flex gap-2 align-items-center justify-content-between p-3">
    <div class="d-flex gap-2 align-items-center">
      <span class="fw-bold">Заказ № <?= $model->id ?></span>
      <span>от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i') ?></span>
    </div>
    <div class="bg-<?= $model->status->bg_color ?> px-3 py-2 rounded-3">
      <?= $model->status->title ?>
    </div>
  </div>
  <div class="row align-items-center p-3 gx-4 gy-4 h-100">
    <div class="col-3 d-none d-sm-flex justify-content-center align-items-center gap-2">
      <?= Html::a(
        Html::img(isset($model->orderItems[0]->product->productImages[0]) ?
          Product::IMG_PATH . $model->orderItems[0]->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'w-75']) .
          "<div class='mt-2'>"
          . $model->orderItems[0]->product->title
          . ((count($model->orderItems) > 1) ? '<span class="text-dark text-break"> ... и ещё ' . count($model->orderItems) - 1 . '</span>' : '')
          . "</div>",
        ['orders/view', 'id' => $model->id],
        ['class' => 'text-decoration-none text-center']
      ) ?>
    </div>
    <div class="col-12 col-sm-5 list d-flex flex-column justify-content-center gap-2">
      <div>Клиент: <span class="fw-bold"> <?= $model->name . " (" . $model->email . ")" ?></span></div>
      <?php if (isset($model->date_delivery)) {
        echo "
          <div>Дата и время доставки: <div class='fw-bold'>"
          . Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y')
          . "<span class='ms-2'>" . Yii::$app->formatter->asTime($model->time_delivery, 'php:H:i') .
          "<span></div>
          </div>
        ";
      } else {
        echo '<div>ПВЗ: <span class="fw-bold">' . $model->pickUp->address . '</span></div>';
      }
      ?>
      <div>Сумма: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
      <div>Товаров: <span class="fw-bold"><?= $model->product_amount ?></span></div>
    </div>
    <div class="col-12 col-sm-4 d-flex flex-column gap-3 justify-content-center">
      <?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-secondary', 'data-pjax' => 0]) ?>
      <?php if ($model->status_id == Status::getStatusId('Новый')) {
        echo Html::a('Принять в работу', ['work', 'id' => $model->id], [
          'class' => 'btn btn-warning btn-work',
          'data-id' => $model->id,
          'data-pjax' => 0,
        ]);
      } else if ($model->status_id == Status::getStatusId('В пути') || $model->status_id == Status::getStatusId('Доставка перенесена')) {
        if (empty($model->address) && $model->status_id == Status::getStatusId('В пути')) {
          echo Html::a('Перенести доставку', ['delay', 'id' => $model->id], ['class' => 'btn btn-outline-danger btn-delay', 'data-pjax' => 0]);
        }
        echo Html::a('Подтвердить получение', ['success', 'id' => $model->id], [
          'class' => 'btn btn-success btn-confirm',
          'data-id' => $model->id,
          'data-pjax' => 0,
        ]);
      }
      ?>
    </div>
  </div>
</div>
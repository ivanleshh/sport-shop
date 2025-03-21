<?php

use app\models\Category;
use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card h-100">
  <div class="border d-flex gap-3 align-items-center justify-content-between p-3">
    <h4 class="fw-bold fs-5 m-0"><?= $model->title ?></h4>
    <span class='text-secondary'><?= $model->category->title ?></span>
  </div>
  <div class="row px-4 py-3 align-items-center h-100">
    <div class="d-flex align-items-center gap-2 col-5">
      <?= Html::a(
        Html::img(isset($model->photo) ? Product::IMG_PATH . $model->photo : Product::NO_PHOTO, ['class' => 'w-100']),
        ['view', 'id' => $model->id],
        ['class' => 'd-flex flex-column justify-content-center text-decoration-none w-100']
      )
      ?>
    </div>
    <div class="d-flex flex-column gap-3 justify-content-center col-7">
      <?= Html::a('Перейти', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-dark']) ?>
      <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
      <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-outline-danger',
        'data' => [
          'confirm' => 'Вы уверены, что хотите удалить элемент?',
          'method' => 'post',
        ],
      ]); ?>
    </div>
  </div>
</div>
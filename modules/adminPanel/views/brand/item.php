<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>

<div class="card h-100 rounded-4 border">
  <div class="border-bottom d-flex gap-2 align-items-center justify-content-between p-3">
    <h4 class="fs-5 m-0"><?= $model->title ?></h4>
  </div>
  <div class="row px-4 py-3 align-items-center h-100">
    <div class="col-5">
      <?= Html::img(isset($model->photo) ? Brand::IMG_PATH . $model->photo : Brand::NO_PHOTO, ['class' => 'w-100']) ?>
    </div>
    <div class="col-7 d-flex flex-column gap-3 justify-content-center">
      <?= Html::a('Изменить', ['update', 'id' => $model->id], [
        'class' => 'btn btn-warning btn-brand-update',
        'data-title' => $model->title,
        'data-image' => Brand::IMG_PATH . $model->photo,
      ]); ?>
      <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-outline-danger btn-remove',
        'data-title' => $model->title,
        'data-pjax' => 0,
      ]); ?>
    </div>
  </div>
</div>
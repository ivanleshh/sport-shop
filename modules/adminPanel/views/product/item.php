<?php

use app\models\Category;
use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card h-100 rounded-4 border">
  <div class="border-bottom d-flex gap-2 align-items-center justify-content-between p-3">
    <h4 class="fs-5 m-0"><?= $model->title ?></h4>
    <span class='text-muted'><?= $model->category->title ?></span>
  </div>
  <div class="row px-4 py-3 align-items-center h-100">
    <div class="col-5">
      <?= Html::a(
        Html::img(isset($model->productImages[0]->photo) ? Product::IMG_PATH . $model->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'w-100']),
        ['/product/view', 'id' => $model->id],
        ['class' => 'd-flex justify-content-center']
      )
      ?>
    </div>
    <div class="col-7 d-flex flex-column gap-3 justify-content-center">
      <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']); ?>
      <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-remove btn-outline-danger',
        'data-title' => $model->title,
        'data-pjax' => 0,
      ]); ?>
    </div>
  </div>
</div>
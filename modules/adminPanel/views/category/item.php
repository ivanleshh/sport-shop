<?php

use app\models\Category;
use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>

<div class="card h-100 rounded-4 border">
  <div class="border-bottom d-flex gap-2 align-items-center justify-content-between p-3">
    <h4 class="fs-5 m-0"><?= $model->title ?></h4>
    <?php if (isset($model->parent->title)) {
      echo "<span class='text-muted'>" . $model->parent->title . "</span>";
    }
    ?>
  </div>
  <div class="row px-4 py-3 align-items-center h-100">
    <div class="col-5">
      <?= Html::a(
        Html::img(isset($model->photo) ? "/" . Category::IMG_PATH . $model->photo : Category::NO_PHOTO, ['class' => 'w-100']),
        ['/catalog/view', 'id' => $model->id],
        ['class' => 'd-flex justify-content-center']
      )
      ?>
    </div>
    <div class="col-7 d-flex flex-column gap-3 justify-content-center">
      <?#= Html::a('Перейти', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-dark']) ?>
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
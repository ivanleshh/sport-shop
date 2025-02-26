<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem; height: 27rem;">
  <div class="d-flex justify-content-between bg-dark w-100 bg-gradient rounded-top-2 px-3 py-2">
    <?= Html::a('+ В сравнение', [''], ['class' => 'text-decoration-none link-light']) ?>
    <?= Html::a('🤍', [''], ['class' => 'text-decoration-none align-self-end']) ?>
  </div>
  <div class="card-body d-flex justify-content-between flex-column">
    <div class="card-img">
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->photo, ['class' => 'w-75 h-100']),
        ['/product/view', 'id' => $model->id], 
        ['class' => 'd-flex flex-column align-items-center']) ?>
    </div>
    <div>
      <h5 class="card-title"><?= $model->title ?></h5>
      <p class="card-text fw-bold"><?= $model->price ?> ₽</p>
      <?= Html::a('В корзину', [''], ['class' => 'btn bg-warning bg-gradient w-100']) ?>
    </div>
  </div>
</div>
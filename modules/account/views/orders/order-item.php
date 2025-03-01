<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card">
  <div class="card-body">
    <div class="d-flex gap-3">
        <?= Html::img(Product::IMG_PATH . $model->product->photo, ['class' => 'img-cart_product']) ?>
        <div class="d-flex flex-column gap-2">
        <h5 class="card-title">
            <?= Html::a($model->product->title, [
                'catalog/view', 'id' => $model->product_id, ['data-pjax' => 0]
            ]) ?>
        </h5>
        <div><?= $model->product_cost ?> ₽</div>
        <div>Количество товара <?= $model->product_amount ?></div>
        <div>Сумма товара <?= $model->product_amount ?></div>
    </div>
    </div>
  </div>
</div>
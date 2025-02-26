<?php
use yii\bootstrap5\Html;
?>
<div class="card">
  <div class="card-body">
    <div class="d-flex gap-3">
        <?= Html::img('/img/' . $model->product->photo, ['class' => 'img-cart_product']) ?>
        <div class="d-flex flex-column gap-2">
            <h5 class="card-title">
                <?= Html::a($model->product->title, [
                    'catalog/view', 'id' => $model->product_id, ['data-pjax' => 0]
                ]) ?>
            </h5>
            <div>
                <?= $model->product->price ?> ₽
            </div>
            <span>Осталось <?= $model->product->count ?> шт.</span>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <div>
            <?= Html::a('Удалить', ['cart/remove-item', 'item_id' => $model->id], 
            ['class' => 'btn btn-outline-danger btn-cart-item-remove']) ?>
        </div>
        <div class="d-flex justify-content-end align-items-center gap-3">
            <?= Html::a('-', ['cart/dec-item', 'item_id' => $model->id], 
                ['class' => 'btn btn-outline-danger btn-cart-item-dec']) ?>
            <?= $model->product_amount ?>
            <?= Html::a('+', ['cart/inc-item', 'item_id' => $model->id], 
                ['class' => 'btn btn-outline-success btn-cart-item-inc']) ?>
            <div>
                Итого: <?= $model->total_amount ?> ₽
            </div>
        </div>
    </div>
  </div>
</div>
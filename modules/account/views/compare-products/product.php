<?php

use app\models\Product;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

?>

<div class="card rounded-3 position-relative h-100" style="width: 17rem;">

  <div class="position-absolute d-flex gap-2 justify-content-end w-100 px-2 py-1">
    <?= Html::a(
      '<i class="bi bi-trash3-fill text-danger fs-6"></i>',
      ['index', 'id' => $model->id],
      ['data-id' => $model->id, 'class' => 'btn-compare text-decoration-none align-self-end'] // 'data-category' => $model->product->category_id
    ) ?>
  </div>

  <div class="card-body d-flex justify-content-between flex-column gap-3 mt-3">
    <div class="card-img d-flex justify-content-center align-items-center h-100">
      <?= Html::a(
        Html::img(isset($model->product->productImages[0]->photo) ? Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'card-img-product']),
        ['/product/view', 'id' => $model->product->id],
        ['class' => 'd-flex flex-column align-items-center']
      ) ?>
    </div>

    <div class="d-flex flex-column gap-2 border-top">
      <span class="fs-6 text-dark mt-2"><?= $model->product->title ?></span>
      <div class="d-flex justify-content-between">
        <span class="card-text text-dark text-nowrap fw-bold"><?= $model->product->price ?> ₽</span>
        <div class="me-2">
          <?= Html::a(
            "<i class='bi bi-suit-heart-fill " . (empty($model->product->favouriteProducts[0]->status) ? 'text-secondary' : 'text-danger') . "'></i>",
            ['/catalog/favourite'],
            ['data-id' => $model->product->id, 'class' => 'btn-favourite text-decoration-none align-self-end']
          ) ?>
        </div>

      </div>

      <?php Pjax::begin([
        'id' => "product-" . $model->product->id . "-pjax",
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
      ]);
      $pjx = "#product-" . $model->product->id . "-pjax";
      ?>

      <?php if (isset($model->product->cartItems[0])) : ?>
        <div class="d-flex align-items-center gap-3">
          <div class="w-100">
            <?= Html::a('Оформить', ['/personal/orders/create'], ['class' => 'btn btn-orange w-100']) ?>
          </div>
          <div>
            <?= Html::a(
              '-',
              ['/cart/dec-item', 'item_id' => $model->product->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-dec', 'data-pjx' => $pjx]
            ) ?>
          </div>
          <div>
            <?= $model->product->cartItems[0]->product_amount ?>
          </div>
          <div>
            <?= Html::a(
              '+',
              ['/cart/inc-item', 'item_id' => $model->product->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-inc', 'data-pjx' => $pjx]
            ) ?>
          </div>
        </div>
      <?php else : ?>
        <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
          ? Html::a(
            'В корзину',
            ['/cart/add', 'product_id' => $model->product->id],
            ['class' => 'btn-cart-add btn btn-warning w-100', 'data-pjx' => $pjx]
          ) : ""
        ?>
      <?php endif; ?>

      <?php Pjax::end(); ?>

    </div>

  </div>
</div>
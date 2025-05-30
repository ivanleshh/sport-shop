<?php

use app\models\Product;
use coderius\swiperslider\SwiperSlider;
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\widgets\Pjax;

$navigation = true;
if (isset($nav)) {
  $navigation = $nav;
}

?>
<div class="card rounded-3" style="width: 18rem; height: 26rem;">
  <div class="card-body position-relative d-flex gap-3 justify-content-between flex-column">

    <div class="position-absolute top-0 end-0 px-2 z-3">
      <?= StarRating::widget([
        'name' => 'mediumStars',
        'value' => $model->mediumStars,
        'pluginOptions' => [
          'theme' => 'krajee-uni',
          'readonly' => true,
          'showClear' => false,
          'showCaption' => false,
          'size' => 'xs',
        ],
      ]); ?>
    </div>

    <?php if ($navigation && count($model->productImages) > 1) : ?>
      <?= SwiperSlider::widget([
        'showPagination' => false,
        'slides' => array_map(
          fn($image) =>
          '<div class="card-img d-flex justify-content-center align-items-center h-100">' .
            Html::a(
              Html::img(
                isset($image->photo) ? Product::IMG_PATH . $image->photo : Product::NO_PHOTO,
                ['class' => 'card-img-product']
              ),
              ['/product/view', 'id' => $model->id],
              ['class' => 'd-flex flex-column align-items-center', 'data-pjax' => 0]
            ) . '</div>',
          $model->productImages
        ),
        'clientOptions' => [
          'pagination' => [
            'clickable' => true,
          ],
        ],
        'options' => [
          'styles' => [
            \coderius\swiperslider\SwiperSlider::CONTAINER => ["width" => "100%", 'height' => '100%'],

            \coderius\swiperslider\SwiperSlider::BUTTON_NEXT => ["color" => "lightgray", 'right' => 0],
            \coderius\swiperslider\SwiperSlider::BUTTON_PREV => ["color" => "lightgray", 'left' => 0],
          ],
        ],
      ]); ?>
    <?php else : ?>
      <div class="card-img d-flex justify-content-center align-items-center h-100">
        <?= Html::a(
          Html::img(isset($model->productImages[0]->photo) ? Product::IMG_PATH . $model->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'card-img-product']),
          ['/product/view', 'id' => $model->id],
          ['class' => 'd-flex flex-column align-items-center', 'data-pjax' => 0]
        ) ?>
      </div>
    <?php endif; ?>

    <?php Pjax::begin([
      'id' => "product-$model->id-pjax",
      'enablePushState' => false,
      'timeout' => 5000,
      'enableReplaceState' => false,
    ]);
    $pjx = "#product-$model->id-pjax";
    ?>

    <div class="d-flex flex-column gap-2 border-top pt-2">

      <div>
        <?= Html::a($model->title, ['/product/view', 'id' => $model->id], ['class' => 'fs-6 text-dark', 'data-pjax' => 0]) ?>
      </div>

      <div class="d-flex gap-2 justify-content-between align-items-center">

        <span class="card-text text-dark fw-bold fs-6"><?= $model->price ?> ₽</span>

        <div class="d-flex gap-3 align-items-center">
          <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) {

            echo "<div>" .
              Html::a(
                "<i class='bi bi-bar-chart-line-fill " . (empty($model->compareProducts[0]->status) ? 'text-secondary' : 'text-warning') . "'></i>",
                ['/catalog/compare'],
                ['data-id' => $model->id, 'class' => 'btn-compare text-decoration-none']
              ) .
              "</div>";

            echo "<div>" .
              Html::a(
                "<i class='bi bi-suit-heart-fill " . (empty($model->favouriteProducts[0]->status) ? 'text-secondary' : 'text-danger') . "'></i>",
                ['/catalog/favourite'],
                ['data-id' => $model->id, 'class' => 'btn-favourite text-decoration-none']
              ) .
              "</div>";
          }
          ?>
        </div>
      </div>

      <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin && isset($model->cartItems[0])) : ?>
        <div class="d-flex align-items-center gap-3">
          <div class="w-100">
            <?= Html::a('Оформить', ['/personal/orders/create'], ['class' => 'btn btn-orange w-100', 'data-pjax' => 0]) ?>
          </div>
          <div>
            <?= Html::a(
              '-',
              ['/cart/dec-item', 'item_id' => $model->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-dec', 'data-pjx' => $pjx]
            ) ?>
          </div>
          <div>
            <?= $model->cartItems[0]->product_amount ?>
          </div>
          <div>
            <?= Html::a(
              '+',
              ['/cart/inc-item', 'item_id' => $model->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-inc', 'data-pjx' => $pjx]
            ) ?>
          </div>
        </div>
      <?php else : ?>
        <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
          ? Html::a(
            'В корзину',
            ['/cart/add', 'product_id' => $model->id],
            ['class' => 'btn-cart-add btn btn-warning w-100', 'data-pjx' => $pjx]
          ) : ""
        ?>
      <?php endif; ?>

    </div>

    <?php Pjax::end(); ?>

  </div>
</div>
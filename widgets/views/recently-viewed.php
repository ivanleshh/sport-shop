<?php

use yii\widgets\Pjax;

if (!empty($products)): ?>

    <?php Pjax::begin([
        'id' => 'recently-viewed-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="recently-viewed-slider hero-content mt-3 w-100 mx-auto">
        <h5 class="mb-3">Вы недавно смотрели</h5>
        <?= \coderius\swiperslider\SwiperSlider::widget([
            'showScrollbar' => false,
            'showPagination' => false,
            'slides' => array_map(fn($product) => $this->render('@app/views/catalog/product', ['model' => $product, 'nav' => false]), $products),
            'clientOptions' => [
                'loop' => false,
                'spaceBetween' => 20,
                'breakpoints' => [
                    0 => [
                        'slidesPerView' => 1.1,
                    ],
                    420 => [
                        'slidesPerView' => 1.2,
                    ],
                    450 => [
                        'slidesPerView' => 1.3,
                    ],
                    475 => [
                        'slidesPerView' => 1.4,
                    ],
                    500 => [
                        'slidesPerView' => 1.5,
                    ],
                    525 => [
                        'slidesPerView' => 1.6,
                    ],
                    768 => [
                        'slidesPerView' => 2.15,
                    ],
                    992 => [
                        'slidesPerView' => 3,
                    ],
                    1200 => [
                        'slidesPerView' => 3.5,
                    ],
                    1400 => [
                        'slidesPerView' => 4,
                    ],
                ],
            ],
            'options' => [
                'styles' => [
                    \coderius\swiperslider\SwiperSlider::BUTTON_PREV => ["color" => "lightGray"],
                    \coderius\swiperslider\SwiperSlider::BUTTON_NEXT => ["color" => "lightGray"],
                ],
            ],

        ]); ?>
    </div>

    <?php Pjax::end(); ?>

<?php endif; ?>
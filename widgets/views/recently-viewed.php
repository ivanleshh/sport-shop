<?php

if (!empty($products)): ?>
    <div class="recently-viewed-slider hero-content mt-3 w-100 mx-auto">
        <h5 class="mb-3">Вы недавно смотрели</h5>
        <?= \coderius\swiperslider\SwiperSlider::widget([
            'showScrollbar' => false,
            'showPagination' => false,
            'slides' => array_map(fn($product) => $this->render('@app/views/catalog/product', ['model' => $product, 'nav' => false]), $products),
            'clientOptions' => [
                'loop' => false,
                'spaceBetween' => 25,
                'breakpoints' => [
                    0 => [
                        'slidesPerView' => 1.3,
                    ],
                    450 => [
                        'slidesPerView' => 1.5,
                    ],
                    500 => [
                        'slidesPerView' => 1.7,
                    ],
                    576 => [
                        'slidesPerView' => 1.9,
                    ],
                    650 => [
                        'slidesPerView' => 2.2,
                    ],
                    725 => [
                        'slidesPerView' => 2.4,
                    ],
                    768 => [
                        'slidesPerView' => 2.5,
                    ],
                    850 => [
                        'slidesPerView' => 2.8,
                    ],
                    992 => [
                        'slidesPerView' => 3.3,
                    ],
                    1100 => [
                        'slidesPerView' => 3.7,
                    ],
                    1200 => [
                        'slidesPerView' => 4,
                    ],
                ],
            ],
            'options' => [
                'styles' => [
                    \coderius\swiperslider\SwiperSlider::CONTAINER => ["height" => "92%"],
                    \coderius\swiperslider\SwiperSlider::BUTTON_NEXT => ["color" => "orange"],
                    \coderius\swiperslider\SwiperSlider::BUTTON_PREV => ["color" => "orange"],
                ],
            ],

        ]); ?>
    </div>

<?php endif; ?>
<?php

use yii\data\ArrayDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

if (!empty($tranding_categories)): ?>

    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="mb-0">Популярные категории</h2>
                    </div>
                </div>
            </div>
            <?= ListView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $tranding_categories
                ]),
                'itemOptions' => ['class' => 'item col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 gy-3 h-100'],
                'itemView' => 'category',
                'layout' => '<div class="row justify-content-center">{items}</div>',
            ]) ?>
        </div>
    </section>

<?php endif; ?>
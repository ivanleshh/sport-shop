<?php

use app\models\Category;
use yii\bootstrap5\Html;
?>
<div class="card h-100">
    <div class="card-body">
        <?= Html::a(
            (isset($model->photo) ? Html::img("/" . Category::IMG_PATH . $model->photo, ['class' => 'main-popular-img', 'alt' => 'photo']) : '') .
            ($model?->parent_id ? "<span class='text-secondary my-1'>" . $model->parent->title . "</span>" : '') . 
            "<h6 class='card-title fw-semibold link-dark'>$model->title</h6>"
            ,
            ['/catalog/view', 'id' => $model->id],
            ['class' => 'text-center d-flex flex-column align-items-center w-100 h-100', 'data-pjax' => 0]
        ) ?>
    </div>
</div>
<?php

use app\models\Brand;
use yii\bootstrap5\Html;
?>
<div class="card h-100">
    <div class="card-body d-flex flex-column align-items-center justify-content-center w-100 h-100">
        <?= isset($model->photo) ? Html::img(Brand::IMG_PATH . $model->photo, ['class' => 'main-popular-img', 'alt' => 'photo']) : '' ?>
        <h6 class='card-title fw-semibold text-center mt-2'><?= $model->title ?></h6>
    </div>
</div>
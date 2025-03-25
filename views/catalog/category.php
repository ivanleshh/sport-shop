<?php

use app\models\Category;
use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

?>
<div class="card <?= isset($model->parent_id) ? "rounded-4" : 'border-0' ?>">
    <div class="card-body <?= isset($model->parent_id) ? "rounded-4 p-0" : 'border-0 p-0' ?>">
        <?php
            echo Html::a(
                (isset($model->parent_id)
                ? (isset($model->photo) ? Html::img(Category::IMG_PATH . $model->photo, ['class' => 'w-mini']) : '')
                : ''
                ) . 
                "<h5 class='card-title" . (isset($model->parent_id) ? 
                " fs-6 mb-0" : 'text-uppercase fw-bold border-bottom border-3 border-danger pe-2') . "'>$model->title</h5>",
                ['view', 'id' => $model->id],
                ['class' => 'd-flex gap-3 align-items-center link-dark text-decoration-none p-2', 'data-pjax' => 0]
            )
        ?>

        <?php if (!empty($model->children)): ?>
            <div class="d-flex flex-wrap gap-3 float-end p-2">
                <?php foreach ($model->children as $child): ?>
                    <?= $this->render('category', ['model' => $child]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>
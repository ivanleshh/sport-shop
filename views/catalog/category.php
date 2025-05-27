<?php

use app\models\Category;
use yii\bootstrap5\Html;

?>
<div class="card h-100 <?= isset($model->parent_id) ? "rounded-4 card-category" : 'border-0' ?>">
    <div class="card-body h-100 p-0 <?= isset($model->parent_id) ? "border-0" : '' ?>">
        <?php
            echo Html::a(
                (isset($model->parent_id)
                ? (isset($model->photo) ? Html::img("/" . Category::IMG_PATH . $model->photo, ['class' => 'w-mini']) : '')
                : ''
                ) . 
                "<h5 class='card-title ellipsis" . (isset($model->parent_id) ? 
                " fs-6 mb-0 fw-medium" : ' border-bottom border-3 border-danger') . "'>$model->title</h5>",
                ['view', 'id' => $model->id],
                ['class' => 'd-flex gap-2 p-2 h-100 ' . (isset($model->parent_id) ? 'justify-content-center' : '') 
                . ' align-items-center link-dark text-decoration-none', 'data-pjax' => 0]
            )
        ?>

        <?php if (empty($noChild) && !empty($model->children)): ?>
            <div class="d-flex flex-wrap gap-3">
                <?php foreach ($model->children as $child): ?>
                    <?= $this->render('category', ['model' => $child]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>
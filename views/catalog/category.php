<?php

use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

?>
<div class="card">
    <div class="card-body p-2">
        <?php
            echo Html::a(
                (isset($model->parent_id)
                ? Html::img('/images/' . $model->photo, ['class' => 'w-mini'])
                : ''
                ) . 
                "<h5 class='card-title " . (isset($model->parent_id) ? 
                "fs-6" : 'text-uppercase fw-bold mt-2 ms-2 pe-2 border-bottom border-3 border-primary') . "'>$model->title</h5>",
                ['view', 'id' => $model->id],
                ['class' => 'd-flex gap-3 align-items-center link-dark text-decoration-none', 'data-pjax' => 0]
            )
        ?>

        <?php if (!empty($model->children)): ?>
            <div class="mt-2 d-flex flex-wrap gap-3">
                <?php foreach ($model->children as $child): ?>
                    <?= $this->render('category', ['model' => $child]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>
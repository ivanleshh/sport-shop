<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */

?>
<div class="orders-update">
    <?= $this->render('_form-modal', [
        'model_delay' => $model_delay,
    ]) ?>
</div>

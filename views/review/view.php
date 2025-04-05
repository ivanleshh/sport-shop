<?php

use app\models\Comment;
use app\models\Review;
use app\models\User;
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<div class="review border rounded-4 p-3">
    <div class="review-top d-flex gap-3 align-items-center justify-content-between flex-wrap">
        <div class="review-top-user d-flex gap-3">
            <div>
                <?= Html::img(User::CLIENT_PHOTO, ['class' => 'review-avatar rounded-circle']) ?>
            </div>
            <div>
                <span class="fw-bold text-dark"><?= Html::encode($model->user->nameSurname) ?></span>
                <div>
                    <?= StarRating::widget([
                        'name' => 'review-stars',
                        'value' => $model->stars,
                        'pluginOptions' => [
                            'theme' => 'krajee-uni',
                            'readonly' => true,
                            'showClear' => false,
                            'showCaption' => false,
                            'size' => 'sm',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="review-top-date d-flex gap-2 flex-column align-self-start">
            <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:H:i d.m.Y') ?>
            <?= is_null($model->parent_id) ? Html::a("Ответить", ['/review/create', 'product_id' => $model->product->id],
            ['data-parent-id' => $model->id, 'class' => 'btn btn-outline-secondary btn-add-reply px-4 py-2']) : '' ?>
        </div>
    </div>
    <p class="m-0"><?= Html::encode($model->text) ?></p>
</div>

<?php if (!empty($model->children)): ?>
    <div class="mt-3 ms-5 d-flex flex-column gap-3">
        <?php foreach ($model->children as $child): ?>
            <?= $this->render('review', ['model' => $child]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
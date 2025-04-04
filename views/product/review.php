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
            <?= is_null($model->parent_id) ? Html::button('Ответить', ['class' => 'btn border border-secondary p-0 btn-answer']) : '' ?>
        </div>
    </div>
    <p class="m-0"><?= Html::encode($model->text) ?></p>
</div>

<?php if (is_null($model->parent_id)) : ?>
    <div class="answer-form answer-hide">
        <?php Pjax::begin(); ?>

        <?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin ?
            $this->render('_form-review.php', ['model' => new Review(), 'parent_id' => $model->id]) : '' ?>
        <?php Pjax::end(); ?>
    </div>
<?php endif; ?>

<?php if (!empty($model->children)): ?>
    <div class="mt-3 ms-5 d-flex flex-column gap-3">
        <?php foreach ($model->children as $child): ?>
            <?= $this->render('comment', ['model' => $child]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->registerJsFile('/js/answer.js', ['depends' => JqueryAsset::class]) ?>
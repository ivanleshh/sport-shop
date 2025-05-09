<?php

use app\models\Comment;
use app\models\Review;
use app\models\User;
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<div class="review border rounded-4 p-3">
    <div class="review-top row">
        <div class="review-top-user col-12 col-sm-8 d-flex gap-3 align-items-center">
            <div>
                <?= Html::img(User::CLIENT_PHOTO, ['class' => 'review-avatar rounded-circle']) ?>
            </div>
            <div>
                <span class="fw-bold text-dark"><?= Html::encode($model->user->nameSurname) ?></span>
                <?php if (isset($model->stars)) : ?>
                    <div>
                        <?= StarRating::widget([
                            'name' => 'view-stars',
                            'value' => $model->stars,
                            'pluginOptions' => [
                                'theme' => 'krajee-uni',
                                'showClear' => false,
                                'showCaption' => false,
                                'size' => 'sm',
                                'displayOnly' => true,
                                'disabled' => true,
                                'readonly' => true,
                            ],
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="review-top-date col-12 col-sm-4 d-flex gap-2 gap-sm-0 flex-sm-column justify-content-between aling-items-end">
            <span class="text-end mt-1"><?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y') ?></span>
            <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
                echo Html::a(
                    "<i class='bi bi-reply-fill me-2 text-warning fs-5'></i>" . "Ответить",
                    ['/review/create', 'product_id' => $model->product->id],
                    ['data-parent-id' => $model->id, 'class' => 'btn-add-reply text-dark text-end']
                );
            }
            ?>
        </div>
    </div>
    <p class="my-2"><?= Html::encode($model->text) ?></p>

    <?php if (!empty($model->reviews)): ?>
        <div class="mt-2">
            <a class="text-docoration-none text-dark" data-bs-toggle="collapse" href="#reply-list-<?= $model->id ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="bi bi-arrow-90deg-down me-2"></i>
                <span>Комментарии ( <?= count($model->reviews) ?> )</span>
            </a>
        </div>
        <div class="collapse mt-3" id="reply-list-<?= $model->id ?>">
            <div class="d-flex flex-column gap-3">
                <?php foreach ($model->reviews as $child): ?>
                    <?= $this->render('view', ['model' => $child]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
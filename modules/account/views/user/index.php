<?php

use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Личный кабинет',
];
?>

<div class="toast-container position-fixed top-0 end-0 px-4"></div>

<div class="hero-content user-index">

    <?php Pjax::begin([
        'id' => 'personal-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]);
    ?>

    <div class="toast-data position-fixed top-0 end-0 px-4"
        data-bg-color="<?= Yii::$app->session->get('bg_color') ?>" data-text="<?= Yii::$app->session->get('text') ?>"></div>

    <?php if (Yii::$app->session->get('bg_color') !== null) {
        Yii::$app->session->remove('bg_color');
        Yii::$app->session->remove('text');
    } ?>

    <div class="d-flex flex-wrap gap-3">
        <?= Html::a("🥇 Сравнение товаров", ['/personal/compare-products'], ['class' => 'btn btn-outline-dark']) ?>
        <?= Html::a("<i class='bi bi-bag-heart-fill me-2'></i>Избранное", ['/personal/favourite-products'], ['class' => 'btn btn-outline-danger']) ?>
        <?= Html::a("<i class='bi bi-truck me-2'></i>История заказов", ['/personal/orders'], ['class' => 'btn btn-outline-warning']) ?>
    </div>

    <div class="user-personal-form col-md-4 mt-3">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'surname',
                'login',
                'email:email',
                [
                    'attribute' => 'password',
                    'value' => '************'
                ]
            ],
        ]) ?>
        <div class="d-flex gap-2">
            <?= Html::a('Изменить персональные данные', ['change-personal', 'id' => $model->id], ['class' => 'btn btn-primary btn-change-personal']) ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>

<?php
if ($dataProvider->count) {
    Modal::begin([
        'id' => 'change-personal-modal',
        'title' => 'Изменение персональных данных',
        'size' => 'modal-md',
    ]);
    echo $this->render('update', compact('model'));
    Modal::end();
    $this->registerJsFile('/js/change-personal.js', ['depends' => JqueryAsset::class]);
}
?>
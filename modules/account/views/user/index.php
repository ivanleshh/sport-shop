<?php

use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
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
<div class="hero-content user-index">
    <?php Pjax::begin([
        'id' => 'personal-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]);
    ?>
    <?php if (Yii::$app->session->hasFlash('change-personal')) {
        Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('change-personal'));
        Yii::$app->session->removeFlash('change-personal');
        echo Alert::widget();
    } ?>
    <div class="d-flex flex-wrap gap-3">
        <?= Html::a("🤍 Избранное", ['/personal/favourite-products'], ['class' => 'btn btn-outline-danger mb-3']) ?>
        <?= Html::a('История заказов', ['/personal/orders'], ['class' => 'btn btn-warning mb-3']) ?>
    </div>
    
    <div class="user-personal-form col-md-4">
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
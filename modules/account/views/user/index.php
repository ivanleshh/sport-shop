<?php

use app\models\User;
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

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h3 class="mb-4"><?= Html::encode($this->title) ?></h3>

    <?php if (Yii::$app->session->hasFlash('change-personal')) {
        Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('change-personal'));
        Yii::$app->session->removeFlash('change-personal');
    }
    ?>

    <div class="user-personal-form col-md-4">
        <?php Pjax::begin([
            'id' => 'personal-pjax',
            'enablePushState' => false,
            'timeout' => 5000,
        ]); ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'surname',
                    'login',
                    'email:email',
                    [
                        'label' => 'пароль',
                        'value' => '************'
                    ]
                ],
            ]) ?>
            
            <div>
                <?= Html::a('Изменить персональные данные', ['change-personal', 'id' => $model->id], ['class' => 'btn btn-primary btn-change-personal']) ?>
            </div>

        <?php Pjax::end(); ?>
    </div>

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
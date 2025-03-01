<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
if (isset($model->parent_id)) {
    $this->params['breadcrumbs'][] = ['label' => $model->parent->title, 'url' => ['view', 'id' => $model->parent->id]];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?= Alert::widget() ?>

    <?php if (!empty($model->children)): ?>
        <div class="my-3 d-flex flex-wrap gap-3">
            <?php foreach ($model->children as $child): ?>
                <?= $this->render('category', ['model' => $child]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-3">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('price', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('сбросить', ['/catalog'], ['class' => 'text-decoration-none link-dark']) ?>
        </div>
        <div>
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'product',
        'layout' => '<div class="catalog-items d-flex flex-wrap gap-3">{items}</div>'
    ]) ?>

    <?php Pjax::end(); ?>

    <p class="my-5"><?= $model->description ?></p>

</div>

<?= $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]); ?>


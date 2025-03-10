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

    <?php if (!empty($model->children)): ?>
        <div class="my-3 d-flex flex-wrap gap-3">
            <?php foreach ($model->children as $child): ?>
                <?= $this->render('category', ['model' => $child]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex gap-3 flex-wrap my-2">
            Сортировать по:
            <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('price', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/catalog/view', 'id' => $model->id], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
        <div>
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>
    </div>

    <?= Alert::widget() ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'product',
        'layout' =>
            '<div class="d-flex justify-content-center mt-4">{pager}</div>
            <div class="catalog-items d-flex flex-wrap gap-3">{items}</div>
            <div class="d-flex justify-content-center mt-4">{pager}</div>',
    ]) ?>

    <?php Pjax::end(); ?>

    <p class="my-5"><?= $model->description ?></p>

</div>

<?= $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]); ?>
<?= $this->registerJsFile('/js/filter-catalog.js', ['depends' => JqueryAsset::class]); ?>

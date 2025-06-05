<?php

namespace app\modules\account\controllers;

use app\models\Category;
use app\models\CompareProducts;
use app\models\ProductProperty;
use app\modules\account\models\CompareProductsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * CompareProductsController implements the CRUD actions for CompareProducts model.
 */
class CompareProductsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CompareProducts models.
     *
     * @return string
     */
    public function actionIndex($id = null)
    {
        $searchModel = new CompareProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $categories = Category::find()->joinWith('products.compareProducts')
            ->where(['compare_products.user_id' => Yii::$app->user->id])
            ->andWhere(['compare_products.status' => 1])
            ->distinct()
            ->all();
        $groupedProducts = CompareProducts::getGroupedProducts($dataProvider);
        $groupedProperties = CompareProducts::getGroupedProperties($groupedProducts);
        if ($id) {
            if ($model = $this->findModel($id)) {
                $model->status = (int)(! $model->status);
                if ($model->status == 0) {
                    Yii::$app->session->set('bg_color', 'bg-danger');
                    Yii::$app->session->set('text', $model->product->title . ' удалён из Сравнения');
                }
                $model->save();
                return $this->asJson(['status' => true]);
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'models' => $dataProvider->models,
            'categories' => $categories,
            'groupedProducts' => $groupedProducts,
            'properties' => $groupedProperties,
        ]);
    }

    /**
     * Displays a single CompareProducts model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing CompareProducts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompareProducts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CompareProducts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompareProducts::findOne([
            'user_id' => Yii::$app->user->id,
            'id' => $id
        ])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена');
    }
}

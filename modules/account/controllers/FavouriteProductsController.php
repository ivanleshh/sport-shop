<?php

namespace app\modules\account\controllers;

use app\models\FavouriteProducts;
use app\modules\account\models\FavouriteProductsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavouriteProductsController implements the CRUD actions for FavouriteProducts model.
 */
class FavouriteProductsController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all FavouriteProducts models.
     *
     * @return string
     */
    public function actionIndex($id = null)
    {
        $searchModel = new FavouriteProductsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if ($id) {
            if ($model = $this->findModel($id)) {
                $model->status = (int)(! $model->status);
                if ($model->status == 0) {
                    Yii::$app->session->set('bg_color', 'bg-danger');
                    Yii::$app->session->set('text', $model->product->title . ' удалён из Избранного');
                }
                $model->save();
                return $this->asJson(['status' => true]);
            }
        }
        return $this->render('index', ['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
    }

    /**
     * Displays a single FavouriteProducts model.
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
     * Deletes an existing FavouriteProducts model.
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
     * Finds the FavouriteProducts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FavouriteProducts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FavouriteProducts::findOne([
            'user_id' => Yii::$app->user->id,
            'id' => $id
        ])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена');
    }
}

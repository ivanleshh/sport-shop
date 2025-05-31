<?php

namespace app\controllers;

use app\models\Review;
use app\models\ReviewSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Метод для сохранения отзывов и комментариев
    public function actionCreate($product_id)
    {
        $model = new Review();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if (is_null($model->parent_id)) {
                $model->scenario = Review::SCENARIO_REVIEW;
            }
            $model->user_id = Yii::$app->user->id;
            $model->product_id = $product_id;
            if ($model->save()) {
                Yii::$app->session->set('bg_color', 'bg-success');
                if (is_null($model->parent_id)) {
                    Yii::$app->session->set('text', 'Благодарим за оценку товара!');
                } else {
                    Yii::$app->session->set('text', 'Ваш комментарий опубликован');
                }
                return $this->render('_form-modal', ['model' => $model]);
            }
        }

        return $this->render('_form-modal', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id №
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

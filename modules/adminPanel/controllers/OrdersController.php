<?php

namespace app\modules\adminPanel\controllers;

use app\models\OrderItem;
use app\models\Orders;
use app\models\Pickup;
use app\models\Status;
use app\modules\adminPanel\models\OrdersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model_delay = null;
        if ($dataProvider->count) {
            $model_delay = $this->findModel($dataProvider->models[0]->id);
            $model_delay->scenario = Orders::SCENARIO_DELAY;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_delay' => $model_delay,
            'pickUps' => Pickup::getPickups(),
            'statuses' => Status::getStatuses(),
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id №
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if ($model = Orders::findOne($id)) {

            $dataProviderr = new ActiveDataProvider([
                'query' => Orders::find()
                    ->where(['id' => $id])
            ]);
            $model_delay = null;
            if ($dataProviderr->count) {
                $model_delay = $this->findModel($dataProviderr->models[0]->id);
                $model_delay->scenario = Orders::SCENARIO_DELAY;
            }

            $dataProvider = new ActiveDataProvider([
                'query' => OrderItem::find()
                    ->where(['order_id' => $id])
                    ->with('product'),
            ]);
            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'dataProviderr' => $dataProviderr,
                'model' => $model,
                'model_delay' => $model_delay,
            ]);
        }
        Yii::$app->session->setFlash('error', 'Заказ не найден');
        // редирект на список заказов пользователя
        return $this->redirect('/admin-panel');
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id №
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelay($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = Orders::SCENARIO_DELAY;
            if ($this->request->isPost && $model->load($this->request->post())) {
                if ($model->status_id == Status::getStatusId('В пути')) {
                    $model->status_id = Status::getStatusId('Доставка перенесена');
                    if ($model->save()) {
                        Yii::$app->session->setFlash('order-delay', "Статус заказа № $model->id изменён на 'Доставка перенесена'");
                        $model->delay_reason = null;
                        return $this->render('_form-modal', [
                            'model' => $model,
                        ]);
                    }
                }
            }
        }
        return $this->render('delay', [
            'model' => $model,
        ]);
    }

    public function actionWork($id)
    {
        if ($model = $this->findModel($id)) {
            if ($model->status_id == Status::getStatusId('Новый')) {
                $model->status_id = Status::getStatusId('В пути');
                $model->save();
                Yii::$app->session->setFlash('warning', "Статус заказа № $model->id изменён на 'В пути'");
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSuccess($id)
    {
        if ($model = $this->findModel($id)) {
            if ($model->status_id == Status::getStatusId('В пути') || $model->status_id == Status::getStatusId('Доставка перенесена')) {
                $model->status_id = Status::getStatusId('Доставлен');
                $model->save();
                Yii::$app->session->setFlash('warning', "Статус заказа № $model->id изменён на 'Доставлен'");
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id №
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

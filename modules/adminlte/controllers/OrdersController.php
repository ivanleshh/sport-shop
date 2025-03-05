<?php

namespace app\modules\adminlte\controllers;

use app\models\OrderItem;
use app\models\Orders;
use app\models\Pickup;
use app\models\Status;
use app\modules\adminlte\models\OrdersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            $dataProvider = new ActiveDataProvider([
                'query' => OrderItem::find()
                    ->where(['order_id' => $id])
                    ->with('product'),
            ]);
            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
        Yii::$app->session->setFlash('error', 'Заказ не найден');
        // редирект на список заказов пользователя
        return $this->redirect('/');
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
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }   
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionWork($id)
    {
        $model = $this->findModel($id);

        if ($model->status_id == Status::getStatusId('Новый')) {
            $model->status_id = Status::getStatusId('В работе');
            $model->save();
            Yii::$app->session->setFlash('warning', "Статус заказа № $model->id изменён на 'В работе'");
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSuccess($id)
    {
        $model = $this->findModel($id);

        if ($model->status_id == Status::getStatusId('В пути')) {
            $model->status_id = Status::getStatusId('Доставлен');
            $model->save();
            Yii::$app->session->setFlash('warning', "Статус заказа № $model->id изменён на 'Доставлен'");
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

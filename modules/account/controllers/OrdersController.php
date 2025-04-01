<?php

namespace app\modules\account\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\OrderItem;
use app\models\Orders;
use app\models\Pickup;
use app\models\Status;
use app\models\Typepay;
use app\modules\account\models\OrdersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * OrdersController implements the CRUD actions for Cart model.
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionCreate()
    {
        $dataProvider = null;
        $cart = null;
        $model = new Orders(['scenario' => Orders::SCENARIO_PICKUP]);

        if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {
            $dataProvider = new ActiveDataProvider([
                'query' => CartItem::find(['cart_id' => $cart->id])->with('product'),
                'pagination' => [
                    'pageSize' => 3
                ],
            ]);
        } else {
            return $this->redirect('/');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->check) {
                $model->scenario = Orders::SCENARIO_DELIVERY;
            }
            $model->status_id = Status::getStatusId('Новый');
            if ($id = Orders::orderCreate($model)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        if (Yii::$app->session->hasFlash('shop')) {
            Yii::$app->session->setFlash('error', Yii::$app->session->getFlash('shop', '', true));
        }

        return $this->render('create', [
            'dataProvider' => $dataProvider,
            'cart' => $cart,
            'model' => $model,
            'typePays' => Typepay::getTypePays(),
            'pickUps' => Pickup::getPickups(),
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

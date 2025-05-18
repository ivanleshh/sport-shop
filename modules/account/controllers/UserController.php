<?php

namespace app\modules\account\controllers;

use app\models\CompareProducts;
use app\models\FavouriteProducts;
use app\models\Orders;
use app\models\User;
use app\modules\account\models\UserSearch;
use Faker\Provider\ar_EG\Company;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $orders = Orders::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(4)
            ->all();
        $countFavourites = FavouriteProducts::getCountAdded();
        $countCompare = CompareProducts::getCountAdded();

        $model = null;
        if ($dataProvider->count) {
            $model = $this->findModel($dataProvider->models[0]->id);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'orders' => $orders,
            'countFavourites' => $countFavourites,
            'countCompare' => $countCompare,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangePersonal($id)
    {
        $model = $this->findModel($id);
        $password_old = $model->password;

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->check) {
                $model->scenario = User::SCENARIO_PASSWORD;
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            } else {
                $model->password = $password_old;
            }
            if ($model->save(false)) {
                Yii::$app->session->set('bg_color', 'bg-success');
                Yii::$app->session->set('text', 'Вы успешно изменили персональные данные');
                return $this->render('_form', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

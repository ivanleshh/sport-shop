<?php

namespace app\modules\adminPanel\controllers;

use app\models\LoginForm;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Сontroller for the Admin login
 */
class LoginController extends Controller
{
    public $layout = 'login';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect("/");
        }

        $model = new LoginForm(['scenario' => LoginForm::SCENARIO_ADMIN]);
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вы успешно вошли в панель администратора');
            return $this->redirect('/admin-panel/orders');
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
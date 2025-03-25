<?php

namespace app\modules\adminPanel\controllers;

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
        return $this->render('index');
    }
}
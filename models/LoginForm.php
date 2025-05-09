<?php

namespace app\models;

use Codeception\Scenario;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_CLIENT = 'client';

    public $email;
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['login', 'required', 'on' => self::SCENARIO_CLIENT],
            ['email', 'required', 'on' => self::SCENARIO_ADMIN],

            ['email', 'email'],

            ['login', 'match', 'pattern' => '/^[a-z\-\d]+$/i', 'message' => 'Разрешённые символы: латиница, тире, цифры'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z\s\d\^\+\-\<\>]+$/', 'message' => 'Разрешённые символы: латиница, пробел, ^, +, -, <, >'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/^(?=.*[\d]).+$/', 'message' => 'Должна быть хотя бы одна цифра'],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z]).+$/', 'message' => 'Должна быть хотя бы одна строчная буква'],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Z]).+$/', 'message' => 'Должна быть хотя бы одна заглавная буква'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => self::SCENARIO_CLIENT],
            ['password', 'validateAdminPassword', 'on' => self::SCENARIO_ADMIN],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Не выходить из системы'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || $user->role_id !== Role::getRoleId('user') || !$user->validatePassword($this->password)) {
                Yii::$app->session->setFlash('danger', 'Пара логин - пароль введены некорректно');
                $this->addError($attribute, 'Неверный логин или пароль');
            }
        }
    }

    /**
     * Validates the admin password.
     * This method serves as the inline validation for admin password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateAdminPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();

            if (!$admin || $admin->role_id !== Role::getRoleId('admin') || !$admin->validatePassword($this->password)) {
                Yii::$app->session->setFlash('danger', 'Пара почта - пароль введены некорректно');
                $this->addError($attribute, 'Неверная почта или пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided login and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByLogin($this->login);
        }

        return $this->_user;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    public function getAdmin()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}

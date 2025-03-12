<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public string $name = '';
    public string $surname = '';
    public string $login = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public bool $rules = false;
    public bool $personal = false;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat'], 'required'],
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat'], 'string', 'max' => 255],
            [['email', 'login'], 'unique', 'targetClass' => User::class],
            ['name', 'match', 'pattern' => '/^[а-яё\-\s]+$/ui', 'message' => 'Разрешённые символы: кириллица, тире и пробел'],
            ['surname', 'match', 'pattern' => '/^[а-яё\-\s]+$/ui', 'message' => 'Разрешённые символы: кириллица, тире и пробел'],
            ['login', 'match', 'pattern' => '/^[a-z\-\d]+$/i', 'message' => 'Разрешённые символы: латиница, тире, цифры'],
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z\s\d\^\+\-\<\>]+$/', 'message' => 'Разрешённые символы: латиница, пробел, ^, +, -, <, >'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/^(?=.*[\d]).+$/', 'message' => 'Должна быть хотя бы одна цифра'],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z]).+$/', 'message' => 'Должна быть хотя бы одна строчная буква'],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Z]).+$/', 'message' => 'Должна быть хотя бы одна заглавная буква'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['rules', 'required', 'requiredValue' => true, 'message' => 'Необходимо принять условия пользовательского соглашения'],
            ['personal', 'required', 'requiredValue' => true, 'message' => 'Необходимо согласиться с обработкой персональных данных'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'login' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'personal' => 'Я согласен на обработку персональных данных',
            'rules' => 'Я принимаю условия пользовательского соглашения',
        ];
    }

    // Метод для заполнения данных пользователя в модель и её сохранения в базу данных
    public function userRegister(): User|false
    {
        if ($this->validate()) {
            $user = new User;
            $user->load($this->attributes, '');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->role_id = Role::getRoleId('user');
            $user->save(false);
        }
        return $user ?? false;
    }
}
<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $login
 * @property string $email
 * @property string $password
 * @property int $role_id
 * @property string $auth_key
 *
 * @property Cart[] $carts
 * @property Comment[] $comments
 * @property Orders[] $orders
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public bool $check = false;
    public string $password_repeat = '';
    const SCENARIO_PASSWORD = 'password';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email'], 'required'],
            [['role_id'], 'integer'],
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat', 'auth_key'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],

            [['email', 'login'], 'unique', 'targetClass' => User::class],
            ['name', 'match', 'pattern' => '/^[а-яё\-\s]+$/ui', 'message' => 'Разрешённые символы: кириллица, тире и пробел'],
            ['surname', 'match', 'pattern' => '/^[а-яё\-\s]+$/ui', 'message' => 'Разрешённые символы: кириллица, тире и пробел'],
            ['login', 'match', 'pattern' => '/^[a-z\-\d]+$/i', 'message' => 'Разрешённые символы: латиница, тире, цифры'],
            ['email', 'email'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z\s\d\^\+\-\<\>]+$/', 'message' => 'Разрешённые символы: латиница, пробел, ^, +, -, <, >', 'on' => self::SCENARIO_PASSWORD],
            ['password', 'string', 'min' => 8, 'on' => self::SCENARIO_PASSWORD],
            ['password', 'match', 'pattern' => '/^(?=.*[\d]).+$/', 'message' => 'Должна быть хотя бы одна цифра', 'on' => self::SCENARIO_PASSWORD],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z]).+$/', 'message' => 'Должна быть хотя бы одна строчная буква', 'on' => self::SCENARIO_PASSWORD],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Z]).+$/', 'message' => 'Должна быть хотя бы одна заглавная буква', 'on' => self::SCENARIO_PASSWORD],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_PASSWORD],

            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_PASSWORD],
            ['check', 'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'login' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'role_id' => 'Role ID',
            'auth_key' => 'Auth Key',
            'check' => 'Изменить пароль',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Reactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReactions()
    {
        return $this->hasMany(Reaction::class, ['user_id' => 'id']);
    }

    // Метод для поиска пользователя по его логину
    public static function findByLogin($login)
    {
        return self::findOne(compact('login'));
    }

    // Метод для сравнения вводимого посетителем пароля и хэша пароля пользователя из базы данных
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    // Метод для проверки является ли текущий пользователь администратором
    public function getIsAdmin()
    {
        return $this->role_id == Role::getRoleId('admin');
    }
}

<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $type_pay_id
 * @property int|null $pick_up_id
 * @property string|null $address
 * @property string|null $date_delivery
 * @property string|null $time_delivery
 * @property string|null $comment
 * @property float $total_amount
 * @property int $product_amount
 * @property int $status_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $delay_reason
 * @property string|null $new_date_delivery
 *
 * @property OrderItem[] $orderItems
 * @property Pickup $pickUp
 * @property Status $status
 * @property Typepay $typePay
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    public bool $check = false;
    const SCENARIO_DELIVERY = 'delivery';
    const SCENARIO_PICKUP = 'pickup';
    const SCENARIO_DELAY = 'delay';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'type_pay_id', 'product_amount', 'status_id', 'user_id'], 'required'],
            [['type_pay_id', 'pick_up_id', 'product_amount', 'status_id', 'user_id'], 'integer'],
            [['comment', 'delay_reason', 'address', 'date_delivery', 'time_delivery'], 'string'],
            [['created_at', 'updated_at', 'new_date_delivery', 'delay_reason'], 'safe'],
            [['total_amount'], 'number'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['pick_up_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pickup::class, 'targetAttribute' => ['pick_up_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['type_pay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Typepay::class, 'targetAttribute' => ['type_pay_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],

            [['address', 'comment'], 'default', 'value' => null],

            [['delay_reason', 'new_date_delivery'], 'required', 'on' => self::SCENARIO_DELAY],

            ['email', 'email'],
            ['name', 'match', 'pattern' => '/^[а-яё\-\s]+$/ui', 'message' => 'Разрешённые символы: кириллица, тире и пробел'],
            ['check', 'boolean'],
            ['pick_up_id', 'required', 'on' => self::SCENARIO_PICKUP],
            [['address', 'date_delivery', 'time_delivery'], 'required', 'on' => self::SCENARIO_DELIVERY],
            ['phone', 'match', 'pattern' => '/^\+7\([\d]{3}\)\-[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'Формат +7(XXX)-XXX-XX-XX'],

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
            'email' => 'Email',
            'phone' => 'Телефон',
            'type_pay_id' => 'Тип оплаты',
            'pick_up_id' => 'Пункт выдачи',
            'check' => 'Доставка',
            'address' => 'Адрес доставки',
            'date_delivery' => 'Дата доставки',
            'time_delivery' => 'Время доставки',
            'comment' => 'Комментарий курьеру',
            'total_amount' => 'Общая сумма заказа',
            'product_amount' => 'Количество товаров',
            'status_id' => 'Статус заказа',
            'user_id' => 'Клиент',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'delay_reason' => 'Причина задержки',
            'new_date_delivery' => 'Новая дата доставки',
        ];
    }

    public static function orderCreate($orderShop): int|bool
    {
        if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $orderShop->total_amount = $cart->total_amount;
                $orderShop->product_amount = $cart->product_amount;
                $orderShop->save();

                $cartItems = CartItem::find()
                    ->with('product')
                    ->where(['cart_id' => $cart->id])
                    ->all();

                foreach ($cartItems as $cartItem) {
                    $orderItem = new OrderItem();
                    $orderItem->attributes = $cartItem->attributes;
                    $orderItem->order_id = $orderShop->id;
                    $orderItem->product_title = $cartItem->product->title;
                    $orderItem->product_cost = $cartItem->product->price;

                    $product = Product::findOne($cartItem->product_id);
                    $product->count -= $cartItem->product_amount;
                    $product->save(false);
                    $orderItem->save(false);
                }

                $transaction->commit();
                $cart->delete();
                return $orderShop->id;
            } catch (\Exception $e) { // пользовательские ошибки
                $transaction->rollBack();
            } catch (\Throwable $e) {
                $transaction->rollBack(); // стандартные ошибки
            }
        }
        return false;
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[PickUp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPickUp()
    {
        return $this->hasOne(Pickup::class, ['id' => 'pick_up_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[TypePay]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypePay()
    {
        return $this->hasOne(Typepay::class, ['id' => 'type_pay_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

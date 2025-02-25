<?php

namespace app\models;

use Yii;

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
            [['date_delivery', 'time_delivery', 'created_at', 'updated_at', 'new_date_delivery'], 'safe'],
            [['comment', 'delay_reason'], 'string'],
            [['total_amount'], 'number'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
            [['pick_up_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pickup::class, 'targetAttribute' => ['pick_up_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['type_pay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Typepay::class, 'targetAttribute' => ['type_pay_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'type_pay_id' => 'Type Pay ID',
            'pick_up_id' => 'Pick Up ID',
            'address' => 'Address',
            'date_delivery' => 'Date Delivery',
            'time_delivery' => 'Time Delivery',
            'comment' => 'Comment',
            'total_amount' => 'Total Amount',
            'product_amount' => 'Product Amount',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'delay_reason' => 'Delay Reason',
            'new_date_delivery' => 'New Date Delivery',
        ];
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

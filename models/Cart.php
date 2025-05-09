<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id
 * @property float $total_amount
 * @property int $product_amount
 *
 * @property CartItem[] $cartItems
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'product_amount'], 'default', 'value' => 0],
            [['user_id', 'product_amount'], 'integer'],
            [['total_amount'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_amount' => 'Total Amount',
            'product_amount' => 'Product Amount',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
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

    // Метод получения количества товаров в корзины у текущего клиента
    public static function getItemCount()
    {
        $count = 0;
        if ($cart = self::findOne(['user_id' => Yii::$app->user->id])) {
            $count = $cart->product_amount;
        }
        return $count;
    }

    // Метод для пересчета количества товаров корзины и её общей суммы
    public function recalculate()
    {
        $items = CartItem::find()->where(['cart_id' => $this->id])->with('product')->all();

        $productAmount = 0;
        $totalAmount = 0;

        foreach ($items as $item) {
            $productAmount += $item->product_amount;
            $totalAmount += $item->product_amount * $item->product->price;
        }

        $this->product_amount = $productAmount;
        $this->total_amount = $totalAmount;
        $this->save(false);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $text
 * @property string|null $stars
 * @property int|null $parent_id
 * @property string $created_at
 *
 * @property Review $parent
 * @property Product $product
 * @property Review[] $reviews
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{
    const SCENARIO_REVIEW = 'review';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'stars'], 'default', 'value' => null],
            [['user_id', 'product_id', 'text'], 'required'],
            [['user_id', 'product_id', 'parent_id'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            ['stars', 'required', 'on' => self::SCENARIO_REVIEW],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'text' => 'Содержание комментария',
            'stars' => 'Количество звёзд',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Review::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['parent_id' => 'id']);
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

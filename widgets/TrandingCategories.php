<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;

class TrandingCategories extends Widget
{
    public function run()
    {
        $tranding_categories = Category::find()
            ->select([
                'category.*',
                'COUNT(order_item.id) AS total_orders'
            ])
            ->innerJoin('product', 'product.category_id = category.id')
            ->innerJoin('order_item', 'order_item.product_id = product.id')
            ->groupBy('category.id')
            ->orderBy(['total_orders' => SORT_DESC])
            ->limit(6)
            ->all();

        return $this->render('tranding-categories', [
            'tranding_categories' => $tranding_categories,
        ]);
    }
}

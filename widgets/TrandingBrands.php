<?php

namespace app\widgets;

use app\models\Brand;
use yii\base\Widget;

class TrandingBrands extends Widget
{
    public function run()
    {
        $tranding_brands = Brand::find()
            ->select([
                'brand.*',
                'COUNT(order_item.id) AS total_orders'
            ])
            ->innerJoin('product', 'product.brand_id = brand.id')
            ->innerJoin('order_item', 'order_item.product_id = product.id')
            ->groupBy('brand.id')
            ->orderBy(['total_orders' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('tranding-brands', [
            'tranding_brands' => $tranding_brands,
        ]);
    }
}

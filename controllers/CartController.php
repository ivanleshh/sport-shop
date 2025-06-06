<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartItem;
use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = null;
        $cart = null;

        if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {
            $dataProvider = new ActiveDataProvider([
                'query' => CartItem::find(['cart_id' => $cart->id])->with('product'),
                'pagination' => [
                    'pageSize' => 4
                ],
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'cart' => $cart,
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // Метод для добавления товара в корзину
    public function actionAdd($product_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            $cart = Cart::findOne(['user_id' => Yii::$app->user->id]);
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = Yii::$app->user->id;
                $cart->save();
            }
            if ($product = Product::findOne($product_id)) {
                if ($product->count) {
                    $cart_item = CartItem::findOne(['cart_id' => $cart->id, 'product_id' => $product->id]);
                    if (!$cart_item) {
                        $cart_item = new CartItem();
                        $cart_item->cart_id = $cart->id;
                        $cart_item->product_id = $product->id;
                        $cart_item->save();
                    }
                    if ($cart_item->product_amount < $product->count) {
                        $cart_item->product_amount++;
                        $cart_item->total_amount = $cart_item->product_amount * $product->price;
                        $cart_item->save();
                        $cart->product_amount++;
                        $cart->total_amount += $product->price;
                        $cart->save();
                        Yii::$app->session->set('bg_color', 'bg-success');
                        Yii::$app->session->set('text', $product->title . ' добавлен в Корзину');
                        return $this->asJson(['status' => true]);
                    }
                }
                Yii::$app->session->set('bg_color', 'bg-warning');
                Yii::$app->session->set('text', 'Товар закончился на складе!');
                return $this->asJson(['status' => false]);
            }
        }
    }

    // Метод для добавления единицы товара в корзину
    public function actionIncItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart_item = CartItem::findOne($item_id)) {
                $product = Product::findOne($cart_item->product_id);
                if ($cart_item->product_amount < $product->count) {
                    if ($cart_item->product_amount == 0) {
                        Yii::$app->session->set('bg_color', 'bg-success');
                        Yii::$app->session->set('text', $product->title .
                            ' добавлен в Корзину');
                    }
                    $cart_item->product_amount++;
                    $cart_item->total_amount = $cart_item->product_amount * $product->price;
                    $cart_item->save();

                    $cart = Cart::findOne($cart_item->cart_id);
                    $cart->product_amount++;
                    $cart->total_amount += $product->price;
                    $cart->save();

                    return $this->asJson([
                        'status' => true,
                    ]);
                }
                Yii::$app->session->set('bg_color', 'bg-warning');
                Yii::$app->session->set('text', 'Товар закончился на складе!');
                return $this->asJson([
                    'status' => false,
                ]);
            }
        }
    }

    // Метод удаления единицы товара из корзины
    public function actionDecItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart_item = CartItem::findOne($item_id)) {
                $cart_item->product_amount--;
                $cart_item->total_amount -= $cart_item->product->price;
                $cart_item->save();

                $cart = Cart::findOne($cart_item->cart_id);
                $cart->product_amount--;
                $cart->total_amount -= $cart_item->product->price;
                $cart->save();

                if ($cart_item->product_amount === 0) {
                    return $this->actionRemoveItem($item_id);
                }

                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    // Метод удаления товара из корзины
    public function actionRemoveItem($item_id)
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart_item = CartItem::findOne($item_id)) {

                $cart = Cart::findOne($cart_item->cart_id);
                $cart->product_amount -= $cart_item->product_amount;
                $cart->total_amount -= $cart_item->total_amount;
                $cart->save();

                $cart_item->delete();
                Yii::$app->session->set('bg_color', 'bg-danger');
                Yii::$app->session->set('text', $cart_item->product->title .
                    ' удалён из Корзины');
                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    // Метод очистки корзины
    public function actionClear()
    {
        if ($this->request->isPost && $this->request->isAjax) {
            if ($cart = Cart::findOne(['user_id' => Yii::$app->user->id])) {
                $cart->delete();
                Yii::$app->session->set('bg_color', 'bg-warning');
                Yii::$app->session->set('text', 'Корзина очищена');
                return $this->asJson([
                    'status' => true,
                ]);
            }
        }
    }

    // Метод получения количества товаров в корзины у текущего клиента
    public function actionItemCount()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            return Cart::getItemCount();
        }
        return $this->redirect('/');
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

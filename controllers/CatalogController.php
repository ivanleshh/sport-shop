<?php

namespace app\controllers;

use app\models\Brand;
use app\models\Cart;
use app\models\Category;
use app\models\CategorySearch;
use app\models\CompareProducts;
use app\models\FavouriteProducts;
use app\models\Product;
use app\models\ProductSearch;
use app\models\Typepay;
use Yii;
use yii\bootstrap5\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * CatalogController implements the CRUD actions for Category model.
 */
class CatalogController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $category = $this->findModel($id);
        $categoryIds = $this->getAllCategoryIds($id);

        $searchModel = new ProductSearch();
        $params = $this->request->queryParams;
        $params['ProductSearch']['category_id'] = $categoryIds;
        $dataProvider = $searchModel->search($params);

        $brandIds = Product::find()
            ->select('brand_id')
            ->where(['category_id' => $categoryIds])
            ->distinct()
            ->column();

        $brands = Brand::find()
            ->where(['in', 'id', $brandIds])
            ->select(['id','title'])
            ->asArray()
            ->all();

        Cart::checkAndUpdate();

        return $this->render('view', [
            'brands' => ArrayHelper::map($brands, 'id', 'title'),
            'model' => $category,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Возвращает информацию о всех дочерних категориях данной категории
    protected function getAllCategoryIds($categoryId)
    {
        $categories = Category::find()->where(['parent_id' => $categoryId])->all();
        $categoryIds = [$categoryId];
        foreach ($categories as $category) {
            $categoryIds = array_merge($categoryIds, $this->getAllCategoryIds($category->id));
        }
        return $categoryIds;
    }

    // Метод для добавления товара в избранное
    public function actionFavourite()
    {
        if ($this->request->isPost) {
            $id = $this->request->post('id');
            $model = FavouriteProducts::findOne([
                'user_id' => Yii::$app->user->id,
                'product_id' => $id
            ]);
            if (is_null($model)) {
                $model = new FavouriteProducts();
                $model->user_id = Yii::$app->user->id;
                $model->product_id = $id;
                $model->status = 1;
            } else {
                $model->status = (int)!$model->status;
            }

            if ($model->status == 1) {
                Yii::$app->session->set('bg_color', 'bg-success');
                Yii::$app->session->set('text', $model->product->title .
                    ' добавлен в Избранное');
            } else {
                Yii::$app->session->set('bg_color', 'bg-danger');
                Yii::$app->session->set('text', $model->product->title .
                    ' удалён из Избранного');
            }

            $model->save();
            return $this->asJson(['status' => $model->status]);
        }
    }

    // Метод для добавления товара в сравнение
    public function actionCompare()
    {
        if ($this->request->isPost) {
            $id = $this->request->post('id');
            $model = CompareProducts::findOne([
                'user_id' => Yii::$app->user->id,
                'product_id' => $id
            ]);
            if (is_null($model)) {
                $model = new CompareProducts();
                $model->user_id = Yii::$app->user->id;
                $model->product_id = $id;
                $model->status = 1;
            } else {
                $model->status = (int)!$model->status;
            }

            if ($model->status == 1) {
                Yii::$app->session->set('bg_color', 'bg-success');
                Yii::$app->session->set('text', $model->product->title .
                    ' добавлен в Сравнение');
            } else {
                Yii::$app->session->set('bg_color', 'bg-danger');
                Yii::$app->session->set('text', $model->product->title .
                    ' удалён из Сравнения');
            }

            $model->save();
            return $this->asJson(['status' => $model->status]);
        }
    }
}

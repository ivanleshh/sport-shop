<?php

namespace app\controllers;

use app\models\Category;
use app\models\CategorySearch;
use app\models\Product;
use app\models\ProductSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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

        if (empty($categoryIds)) {
            $categoryIds = [0];
        }

        $searchModel = new ProductSearch();
        $params = $this->request->queryParams;
        $params['ProductSearch']['category_id'] = $categoryIds;
        $dataProvider = $searchModel->search($params);

        return $this->render('view', [
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
}

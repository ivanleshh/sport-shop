<?php

namespace app\modules\adminPanel\controllers;

use app\models\Category;
use app\models\CategoryProperty;
use app\models\Product;
use app\models\ProductImage;
use app\models\ProductProperty;
use app\modules\adminPanel\models\ProductSearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id №
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $productProperties = []; // Значения характеристик будут заполнены после выбора категории

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {

                $postData = $this->request->post('ProductProperty', []);
                $productProperties = [];
                // Получаем характеристики выбранной категории
                $categoryProperties = CategoryProperty::find()
                    ->where(['category_id' => $model->category_id])
                    ->all();
                $allowedPropertyIds = ArrayHelper::getColumn($categoryProperties, 'property_id');
                // Обработка значений характеристик
                foreach ($allowedPropertyIds as $index => $propertyId) {
                    $value = $postData[$index]['value'] ?? null;

                    if (!empty($value)) { // Сохраняем только заполненные значения
                        $productProperty = new ProductProperty();
                        $productProperty->product_id = $model->id;
                        $productProperty->property_id = $propertyId;
                        $productProperty->value = $value;
                        $productProperties[] = $productProperty;
                    }
                }
                if (Model::validateMultiple($productProperties)) {
                    foreach ($productProperties as $prop) {
                        $prop->save(false);
                    }
                    Yii::$app->session->setFlash('success', "Товар $model->title успешно создан");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'productProperties' => $productProperties,
            'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
            'properties' => [],
        ]);
    }

    public function actionUploadImages()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $files = UploadedFile::getInstancesByName('imageFiles');
        $product_id = Yii::$app->request->post('product_id', 0);

        $path = Yii::getAlias('@webroot' . Product::IMG_PATH);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $response = [];
        foreach ($files as $file) {
            $fileName = Yii::$app->user->id
                . '_'
                . time()
                . '_'
                . Yii::$app->security->generateRandomString()
                . '.'
                . $file->extension;
            if ($file->saveAs($path . $fileName)) {
                $productImage = new ProductImage();
                $productImage->photo = $fileName;
                $productImage->product_id = $product_id;
                $productImage->save();

                $response[] = [
                    'success' => true,
                    'file' => $fileName,
                    'key' => $productImage->id,
                ];
            } else {
                $response[] = [
                    'success' => false,
                    'error' => $file->error,
                ];
            }
        }

        return $response;
    }

    // public function upload($product_id)
    // {
    //     if ($this->validate()) {
    //         foreach ($this->imageFiles as $file) {
    //             $fileName = Yii::$app->user->id
    //                 . '_'
    //                 . time()
    //                 . '_'
    //                 . Yii::$app->security->generateRandomString()
    //                 . '.'
    //                 . $file->extension;
    //             $file->saveAs(Product::IMG_PATH . $fileName);
    //             $productImage = new ProductImage([
    //                 'photo' => $fileName,
    //                 'product_id' => $product_id
    //             ]);
    //             $productImage->save();
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id №
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Товар $model->title успешно обновлён");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id №
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id №
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetCategoryProperties()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $categoryId = Yii::$app->request->get('category_id');
        if (!$categoryId) {
            return [];
        }
        $categoryProperties = CategoryProperty::find()
            ->where(['category_id' => $categoryId])
            ->with('property')
            ->all();
        return array_map(function ($prop) {
            return [
                'property_id' => $prop->property_id,
                'property_title' => $prop->property->title,
            ];
        }, $categoryProperties);
    }
}

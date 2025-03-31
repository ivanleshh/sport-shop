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
use yii\helpers\VarDumper;
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
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                $this->saveProductProperties($model); // Обработка характеристик
                $this->saveProductImages($model); // Обработка изображений
                Yii::$app->session->setFlash('success', "Товар $model->title успешно создан");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id №
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Product::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Товар не найден');
        }
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                $this->saveProductProperties($model); // Обработка характеристик
                $this->saveProductImages($model); // Обработка изображений
                Yii::$app->session->setFlash('success', "Товар $model->title успешно обновлен");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Сохранение характеристик продукта
     */
    private function saveProductProperties($model)
    {
        $postData = $this->request->post('ProductProperty', []);

        $categoryProperties = CategoryProperty::find()
            ->where(['category_id' => $model->category_id])
            ->all();
        $allowedPropertyIds = ArrayHelper::getColumn($categoryProperties, 'property_id');
        ProductProperty::deleteAll(['product_id' => $model->id]); // Удаление старых характеристик

        $productProperties = [];
        foreach ($allowedPropertyIds as $index => $propertyId) { // Сохрание новых характеристик
            $value = $postData[$index]['value'] ?? null;
            if (!empty($value)) {
                $productProperty = new ProductProperty();
                $productProperty->product_id = $model->id;
                $productProperty->property_id = $propertyId;
                $productProperty->property_value = $value;
                $productProperties[] = $productProperty;
            }
        }
        if (Model::validateMultiple($productProperties)) {
            foreach ($productProperties as $prop) {
                $prop->save(false);
            }
        }
    }

    /**
     * Сохранение и обновление изображений продукта
     */
    private function saveProductImages($model)
    {
        $files = UploadedFile::getInstancesByName('imageFiles');
        $path = Yii::getAlias('@webroot' . Product::IMG_PATH);

        $currentImages = $model->productImages;
        $uploadedFileNames = array_map(fn($file) => $file->name, $files);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($currentImages as $image) { // Удаление изображений, которых больше нет в списке
                if (!in_array($image->photo, $uploadedFileNames)) {
                    $filePath = $path . $image->photo;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $image->delete();
                }
            }

            foreach ($files as $file) { // Загрузка новых изображений
                $isExisting = array_filter($currentImages, fn($img) => $img->photo === $file->name);
                if (!$isExisting) {
                    $fileName = Yii::$app->user->id . '_' . time() . '_' . Yii::$app->security->generateRandomString() . '.' . $file->extension;
                    $file->saveAs($path . $fileName);

                    $productImage = new ProductImage();
                    $productImage->photo = $fileName;
                    $productImage->product_id = $model->id;
                    $productImage->save();
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ошибка обработки изображений: ' . $e->getMessage());
        }
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
        $productId = Yii::$app->request->get('product_id', 0);

        if (!$categoryId) {
            return [];
        }
        $categoryProperties = CategoryProperty::find()
            ->where(['category_id' => $categoryId])
            ->with('property')
            ->all();

        $productProperties = [];
        if ($productId) {
            $productProperties = ProductProperty::find()
                ->where(['product_id' => $productId])
                ->indexBy('property_id')
                ->all();
        }

        return array_map(function ($prop) use ($productProperties) {
            $propertyValue = isset($productProperties[$prop->property_id])
                ? $productProperties[$prop->property_id]->property_value
                : '';
            return [
                'property_id' => $prop->property_id,
                'property_title' => $prop->property->title,
                'property_value' => $propertyValue,
            ];
        }, $categoryProperties);
    }
}

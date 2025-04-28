<?php

namespace app\modules\adminPanel\controllers;

use app\models\Category;
use app\models\CategoryProperty;
use app\models\Property;
use app\modules\adminPanel\models\CategorySearch;
use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
        $categoryProperties = [new CategoryProperty()];

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (is_null($model->imageFile) || $model->upload()) {
                if ($model->save(false)) {
                    $postData = $this->request->post('CategoryProperty', []);
                    $newCategoryProperties = [];
                    foreach ($postData as $item) {
                        $propertyId = $item['property_id'] ?? null;
                        $propertyTitle = $item['property_title'] ?? null;
                        if (empty($propertyId) && empty($propertyTitle)) {
                            continue;
                        }
                        if (!empty($propertyId)) {
                            $existingProperty = CategoryProperty::findOne([
                                'category_id' => $model->id,
                                'property_id' => $propertyId
                            ]);
                            if ($existingProperty) {
                                $newCategoryProperties[] = $existingProperty;
                            } else {
                                $categoryProperty = new CategoryProperty();
                                $categoryProperty->category_id = $model->id;
                                $categoryProperty->property_id = $propertyId;
                                $newCategoryProperties[] = $categoryProperty;
                            }
                        }
                        if (!empty($propertyTitle)) {
                            $newProperty = new Property();
                            $newProperty->title = $propertyTitle;
                            if ($newProperty->save()) {
                                $existingProperty = CategoryProperty::findOne([
                                    'category_id' => $model->id,
                                    'property_id' => $newProperty->id
                                ]);
                                if ($existingProperty) {
                                    $newCategoryProperties[] = $existingProperty;
                                } else {
                                    $categoryProperty = new CategoryProperty();
                                    $categoryProperty->category_id = $model->id;
                                    $categoryProperty->property_id = $newProperty->id;
                                    $newCategoryProperties[] = $categoryProperty;
                                }
                            }
                        }
                    }
                    if (Model::validateMultiple($newCategoryProperties)) {
                        foreach ($newCategoryProperties as $prop) {
                            if ($prop->isNewRecord) {
                                $prop->save(false);
                            }
                        }
                        Yii::$app->session->setFlash('success', "Категория $model->title успешно создана");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'categoryProperties' => $categoryProperties,
            'properties' => ArrayHelper::map(Property::find()->all(), 'id', 'title'),
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryProperties = CategoryProperty::find()->where(['category_id' => $model->id])->all();

        if (empty($categoryProperties)) {
            $categoryProperties = [new CategoryProperty()];
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $categoryProp = [];
            foreach ($this->request->post('CategoryProperty') as $index => $data) {
                $prop = new CategoryProperty();
                $prop->load($data, '');
                $prop->category_id = $model->id;
                $categoryProp[] = $prop;
            }
            if (!Model::validateMultiple($categoryProp)) {
                return \yii\widgets\ActiveForm::validateMultiple($categoryProp);
            }
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (is_null($model->imageFile) || $model->upload()) {
                if ($model->save(false)) {
                    $postData = $this->request->post('CategoryProperty', []);
                    $newCategoryProperties = [];
                    foreach ($postData as $item) {
                        $propertyId = $item['property_id'] ?? null;
                        $propertyTitle = $item['property_title'] ?? null;
                        if (empty($propertyId) && empty($propertyTitle)) {
                            continue;
                        }
                        if (!empty($propertyId)) {
                            $existingProperty = CategoryProperty::findOne([
                                'category_id' => $model->id,
                                'property_id' => $propertyId
                            ]);
                            if ($existingProperty) {
                                $newCategoryProperties[] = $existingProperty;
                            } else {
                                $categoryProperty = new CategoryProperty();
                                $categoryProperty->category_id = $model->id;
                                $categoryProperty->property_id = $propertyId;
                                $newCategoryProperties[] = $categoryProperty;
                            }
                        }
                        if (!empty($propertyTitle)) {
                            $newProperty = new Property();
                            $newProperty->title = $propertyTitle;
                            if ($newProperty->save()) {
                                $existingProperty = CategoryProperty::findOne([
                                    'category_id' => $model->id,
                                    'property_id' => $newProperty->id
                                ]);
                                if ($existingProperty) {
                                    $newCategoryProperties[] = $existingProperty;
                                } else {
                                    $categoryProperty = new CategoryProperty();
                                    $categoryProperty->category_id = $model->id;
                                    $categoryProperty->property_id = $newProperty->id;
                                    $newCategoryProperties[] = $categoryProperty;
                                }
                            }
                        }
                    }
                    if (Model::validateMultiple($newCategoryProperties)) {
                        $newPropertyIds = array_filter(
                            array_map(fn($prop) => $prop->property_id, $newCategoryProperties),
                            fn($id) => !is_null($id)
                        );
                        if (!empty($newPropertyIds)) {
                            CategoryProperty::deleteAll([
                                'and',
                                ['category_id' => $model->id],
                                ['not in', 'property_id', $newPropertyIds]
                            ]);
                        } else {
                            CategoryProperty::deleteAll(['category_id' => $model->id]);
                        }
                        foreach ($newCategoryProperties as $prop) {
                            if ($prop->isNewRecord) {
                                $prop->save(false);
                            }
                        }
                        Yii::$app->session->setFlash('success', "Категория $model->title успешно обновлена");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'categoryProperties' => $categoryProperties,
            'properties' => ArrayHelper::map(Property::find()->all(), 'id', 'title'), // Для dropdown
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}

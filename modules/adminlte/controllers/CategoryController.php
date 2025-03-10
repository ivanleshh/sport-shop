<?php

namespace app\modules\adminlte\controllers;

use app\models\Category;
use app\models\CategoryProperty;
use app\models\Property;
use app\modules\adminlte\models\CategorySearch;
use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
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
                    $categoryProperties = [];
                    $postData = $this->request->post('CategoryProperty', []);

                    foreach ($postData as $item) {
                        $categoryProperty = new CategoryProperty();
                        $propertyId = $item['property_id'] ?? null;
                        $newPropTitle = $item['property_title'] ?? null;

                        // Если выбрано существующее свойство
                        if ($propertyId && !$newPropTitle) {
                            $categoryProperty->property_id = $propertyId;
                        }
                        // Если введено новое название свойства
                        elseif ($newPropTitle) {
                            $newProperty = new Property();
                            $newProperty->title = $newPropTitle;
                            if ($newProperty->save()) {
                                $categoryProperty->property_id = $newProperty->id;
                            }
                        }
                        $categoryProperty->category_id = $model->id;
                        $categoryProperties[] = $categoryProperty;
                    }
                    if (Model::validateMultiple($categoryProperties)) {
                        foreach ($categoryProperties as $prop) {
                            $prop->save(false);
                        }
                        Yii::$app->session->setFlash('success', 'Категория успешно создана');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categoryProperties' => $categoryProperties,
            'properties' => Property::find()->all(), // Список существующих свойств
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
        $categoryProperties = $model->categoryProperties ?: [new CategoryProperty()];

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (is_null($model->imageFile) || $model->upload()) {
                if ($model->save(false)) {
                    $categoryProperties = [];
                    $postData = $this->request->post('CategoryProperty', []);

                    foreach ($postData as $index => $item) {
                        $categoryProperty = $item['id'] ? CategoryProperty::findOne($item['id']) : new CategoryProperty();
                        $propertyId = $item['property_id'] ?? null;
                        $newPropTitle = $item['property_title'] ?? null;

                        if ($propertyId && !$newPropTitle) {
                            $categoryProperty->property_id = $propertyId;
                        } elseif ($newPropTitle) {
                            $newProperty = new Property();
                            $newProperty->title = $newPropTitle;
                            if ($newProperty->save()) {
                                $categoryProperty->property_id = $newProperty->id;
                            }
                        }

                        $categoryProperty->category_id = $model->id;
                        $categoryProperties[] = $categoryProperty;
                    }

                    if (Model::validateMultiple($categoryProperties)) {
                        //Удаляем существующие свойства текущей категории, которых нет в новом списке
                        $newPropertyIds = array_filter(
                            array_map(fn($prop) => $prop->property_id, $categoryProperties),
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
                        foreach ($categoryProperties as $prop) {
                            $prop->save(false);
                        }
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categoryProperties' => $categoryProperties,
            'properties' => Property::find()->all(),
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

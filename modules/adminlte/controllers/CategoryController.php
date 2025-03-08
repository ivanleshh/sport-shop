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
        $props = [new CategoryProperty()];

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (is_null($model->imageFile) || $model->upload()) {
                    VarDumper::dump($this->request->post('CategoryProperty'));
                    die;
                    if ($model->save(false)) {

                        $props = [];
                        foreach ($this->request->post('CategoryProperty') as $item) {
                            $prop = $item['id'] ? CategoryProperty::findOne($item['id']) : new CategoryProperty();
                            $prop->category_id = $model->id;
                            // Если выбрано существующее свойство
                            if (!empty($item['property_id'])) {
                                $prop->property_id = $item['property_id'];
                            }
                            // Если введено новое свойство
                            elseif (!empty($item['property_title'])) {
                                $newProperty = new Property();
                                $newProperty->title = $item['property_title'];
                                if ($newProperty->save()) {
                                    $prop->property_id = $newProperty->id;
                                }
                            }
                            $props[] = $prop;
                        }
                        if (Model::validateMultiple($props)) {
                            CategoryProperty::deleteAll([
                                'category_id' => $model->id,
                                'not in',
                                'id',
                                array_filter(array_column($props, 'id')),
                            ]);
                            foreach ($props as $prop) {
                                $prop->save(false);
                            }
                        }

                        Yii::$app->session->setFlash('success', "Категория $model->title успешно добавлена");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'props' => $props,
            'categories' => Category::getAllCategories(),
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
        $props = CategoryProperty::find()->where(['category_id' => $id])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (is_null($model->imageFile) || $model->upload()) {
                if ($model->save(false)) {

                    $props = [];
                    foreach ($this->request->post('CategoryProperty', []) as $key => $item) {
                        $prop = $item['id'] ? CategoryProperty::findOne($item['id']) : new CategoryProperty();
                        $prop->category_id = $model->id;
                        if (!empty($item['property_id'])) {
                            $prop->property_id = $item['property_id'];
                        } elseif (!empty($item['property_title'])) {
                            $newProperty = new Property();
                            $newProperty->title = $item['property_title'];
                            if ($newProperty->save()) {
                                $prop->property_id = $newProperty->id;
                            }
                        }
                        $props[] = $prop;
                    }
                    if (Model::validateMultiple($props)) {
                        CategoryProperty::deleteAll([
                            'category_id' => $model->id,
                            'not in',
                            'id',
                            array_filter(array_column($props, 'id')),
                        ]);
                        foreach ($props as $prop) {
                            $prop->save(false);
                        }
                    }

                    Yii::$app->session->setFlash('success', "Категория $model->title успешно добавлена");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'props' => $props,
            'categories' => Category::getAllCategories(),
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

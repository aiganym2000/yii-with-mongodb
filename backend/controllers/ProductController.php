<?php

namespace backend\controllers;

use backend\models\ProductImageSearch;
use common\models\ProductEn;
use common\models\ProductKz;
use Yii;
use common\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'img-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@static/temp/'
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();
        $modelEn = new ProductEn();
        $modelKz = new ProductKz();

        if ($model->load(Yii::$app->request->post()) && $modelEn->load(Yii::$app->request->post()) && $modelKz->load(Yii::$app->request->post())) {
            $model->product_en = $modelEn->attributes;
            $model->product_kz = $modelKz->attributes;
            $imagesArr=[];
            $images = UploadedFile::getInstances($model, 'images');
            if ($images !== null) {
                foreach ($images as $image) {
                    $imagePath =  $image->name;
                    $image->saveAs($imagePath);
                    $imagesArr[] = $imagePath;
                }
            }
            $model->images = $imagesArr;
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelEn' => $modelEn,
            'modelKz' => $modelKz,
            ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id)->delete();//todo
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => (int)$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('default', 'The requested page does not exist.'));
    }
}

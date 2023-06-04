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
                    $tmpfile_contents = file_get_contents( $image->tempName );
                    $imagesArr[] = base64_encode($tmpfile_contents);
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
        $modelEn = new ProductEn();
        $modelEn->title = $model->product_en['title'];
        $modelEn->description = $model->product_en['description'];
        $modelKz = new ProductKz();
        $modelKz->title = $model->product_kz['title'];
        $modelKz->description = $model->product_kz['description'];

        $created_at = $model->created_at;
        if ($model->load(Yii::$app->request->post()) && $modelEn->load(Yii::$app->request->post()) && $modelKz->load(Yii::$app->request->post())) {
            $model->product_en = $modelEn->attributes;
            $model->product_kz = $modelKz->attributes;
            $imagesArr=[];
            $images = UploadedFile::getInstances($model, 'images');
            if ($images !== null) {
                foreach ($images as $image) {
                    $tmpfile_contents = file_get_contents( $image->tempName );
                    $imagesArr[] = base64_encode($tmpfile_contents);
                }
            }
            $model->images = $imagesArr;

            $collection = Yii::$app->db->getCollection('product');
            $collection->update(['id'=>(int)$id], [
                'title' => $model->title,
                'description' => $model->description,
                'category_id' => $model->category_id,
                'price' => $model->price,
                'images' => $model->images,
                'status' => $model->status,
                'product_en' => $model->product_en,
                'product_kz' => $model->product_kz,
                'created_at' => $created_at,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelEn' => $modelEn,
            'modelKz' => $modelKz,
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
        $collection = Yii::$app->db->getCollection('product');
        $collection->remove(['id'=>(int)$id]);
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

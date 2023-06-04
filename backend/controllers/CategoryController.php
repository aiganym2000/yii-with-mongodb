<?php

namespace backend\controllers;

use common\models\CategoryEn;
use common\models\CategoryKz;
use Yii;
use common\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $modelEn = new CategoryEn();
        $modelKz = new CategoryKz();

        if ($model->load(Yii::$app->request->post()) && $modelEn->load(Yii::$app->request->post()) && $modelKz->load(Yii::$app->request->post())) {
            $model->category_en = $modelEn->attributes;
            $model->category_kz = $modelKz->attributes;
            $tmpfile = UploadedFile::getInstance($model,'img');
            $tmpfile_contents = file_get_contents( $tmpfile->tempName );
            $model->img = base64_encode($tmpfile_contents);

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
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelEn = new CategoryEn();
        $modelEn->title = $model->category_en['title'];
        $modelEn->description = $model->category_en['description'];
        $modelKz = new CategoryKz();
        $modelKz->title = $model->category_kz['title'];
        $modelKz->description = $model->category_kz['description'];

        $created_at = $model->created_at;
        if ($model->load(Yii::$app->request->post()) && $modelEn->load(Yii::$app->request->post()) && $modelKz->load(Yii::$app->request->post())) {
            $model->category_en = $modelEn->attributes;
            $model->category_kz = $modelKz->attributes;

            $tmpfile = UploadedFile::getInstance($model,'img');
            $tmpfile_contents = file_get_contents( $tmpfile->tempName );
            $model->img = base64_encode($tmpfile_contents);

                $collection = Yii::$app->db->getCollection('category');
                $collection->update(['id'=>(int)$id], [
                    'parent_id' => $model->parent_id,
                    'category_en' => $model->category_en,
                    'category_kz' => $model->category_kz,
                    'title' => $model->title,
                    'img' => $model->img,
                    'description' => $model->description,
                    'status' => $model->status,
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
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $collection = Yii::$app->db->getCollection('category');
        $collection->remove(['id'=>(int)$id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => (int)$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('default', 'The requested page does not exist.'));
    }
}

<?php

namespace backend\controllers;

use Yii;
use common\models\Slider;
use backend\models\SliderSearch;
use yii\mongodb\Connection;
use yii\mongodb\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use yii\web\UploadedFile;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller
{
    /**
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
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
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slider();

        if ($model->load(Yii::$app->request->post())) {
            $tmpfile = UploadedFile::getInstance($model,'image');
            $tmpfile_contents = file_get_contents( $tmpfile->tempName );
            $model->image = base64_encode($tmpfile_contents);

            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $created_at = $model->created_at;
        if ($model->load(Yii::$app->request->post())) {
            $tmpfile = UploadedFile::getInstance($model,'image');
            $tmpfile_contents = file_get_contents( $tmpfile->tempName );
            $model->image = base64_encode($tmpfile_contents);

            $collection = Yii::$app->db->getCollection('slider');
            $collection->update(['id'=>(int)$id], [
                'title' => $model->title,
                'image' => $model->image,
                'slider_position' => $model->slider_position,
                'status' => $model->status,
                'created_at' => $created_at,
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $collection = Yii::$app->db->getCollection('slider');
        $collection->remove(['id'=>(int)$id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne(['id' => (int)$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

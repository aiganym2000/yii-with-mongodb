<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Panel;
use common\models\Category;
use yii\helpers\ArrayHelper;
use vova07\fileapi\Widget as FileAPI;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $modelKz common\models\CategoryKz */
/* @var $modelEn common\models\CategoryEn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php Panel::begin([
        'title' => $this->title,
        'buttonsTemplate' => '{cancel}',
    ]) ?>

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelKz, 'title')->textInput(['maxlength' => true])->label('Название на казахском') ?>
    <?= $form->field($modelEn, 'title')->textInput(['maxlength' => true])->label('Название на английском') ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelKz, 'description')->textInput(['maxlength' => true])->label('Описание на казахском') ?>
    <?= $form->field($modelEn, 'description')->textInput(['maxlength' => true])->label('Описание на английском') ?>

    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(Category::findAll(), 'id', 'title')) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>

    <?= $form->field($model, 'img')->fileInput(['class'=>'btn btn-primary']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Panel::end() ?>

</div>

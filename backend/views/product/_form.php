<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Panel;
use common\models\Category;
use yii\helpers\ArrayHelper;
use vova07\fileapi\Widget as FileAPI;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelKz common\models\ProductKz */
/* @var $modelEn common\models\ProductEn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php Panel::begin([
        "title" => $this->title,
        "buttonsTemplate" => "{cancel}"
    ]) ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelKz, 'title')->textInput(['maxlength' => true])->label('Название на казахском') ?>
    <?= $form->field($modelEn, 'title')->textInput(['maxlength' => true])->label('Название на английском') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($modelKz, 'description')->textInput(['maxlength' => true])->label('Описание на казахском') ?>
    <?= $form->field($modelEn, 'description')->textInput(['maxlength' => true])->label('Описание на английском') ?>

    <?= $form->field($model, 'category_id')->textInput()->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>

    <?= $form->field($model, 'images[]')->widget(FileInput::class, [
        'options' => ['accept' => 'image/*', 'multiple' => true],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Panel::end() ?>
</div>

<?php

use yii\helpers\Html;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use common\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php Panel::begin([
        "title" => $this->title,
        "buttonsTemplate" => "{update}{delete}"
    ]) ?>

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['class'=>'btn btn-primary']) ?>
    <?= $form->field($model, 'slider_position')->dropDownList($model->getPositionList()) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Panel::end(); ?>

</div>

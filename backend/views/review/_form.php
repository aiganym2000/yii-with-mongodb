<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Review;
use \common\models\Product;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Review */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_id')->textInput()->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'title')) ?>
    <?= $form->field($model, 'status')->dropDownList(Review::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

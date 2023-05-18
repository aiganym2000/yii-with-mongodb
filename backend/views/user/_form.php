<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(User::getRoleList()) ?>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusList()) ?>

    <?= $form->field($model, 'password_new')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address[city]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address[street]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address[house_number]')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('default','LOGIN');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <p class="login-box-msg"><?= Yii::t('default','LOGIN') ?></p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => Yii::t('default','LOGIN')])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('default','PASSWORD')])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton( Yii::t('default','LOGIN'), ['class' => 'btn btn-default btn-block', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
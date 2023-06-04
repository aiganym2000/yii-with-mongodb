<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('default', 'UPDATE_PRODUCT') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'PRODUCTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('default', 'UPDATE');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelEn' => $modelEn,
        'modelKz' => $modelKz
    ]) ?>

</div>

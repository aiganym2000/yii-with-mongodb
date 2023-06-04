<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t('default', 'UPDATE_CATEGORY') . ": " . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('default', 'UPDATE');
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelEn' => $modelEn,
        'modelKz' => $modelKz
    ]) ?>

</div>

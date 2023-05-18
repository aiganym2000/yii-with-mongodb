<?php

use yii\helpers\Html;
use common\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = Yii::t('default', 'UPDATE_SLIDER: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'SLIDER'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('default', 'UPDATE');
?>
<div class="slider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

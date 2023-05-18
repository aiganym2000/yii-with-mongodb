<?php

use yii\helpers\Html;
use common\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = Yii::t('default', 'CREATE_SLIDER');
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

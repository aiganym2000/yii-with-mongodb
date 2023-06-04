<?php

use yii\helpers\Html;
use \common\widgets\Panel;
/* @var $this yii\web\View */
/* @var $model common\models\Review */

$this->title = Yii::t('main','Update Review'). $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['breadcrumbs'][] = ['label' => Yii::t('main','REVIEWS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('main','UPDATE');
?>
<div class="review-update">

    <?php Panel::begin([
        "title" => $this->title,
    ])?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php Panel::end() ?>
</div>

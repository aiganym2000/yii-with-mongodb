<?php

use yii\helpers\Html;
use common\widgets\Panel;
/* @var $this yii\web\View */
/* @var $model common\models\Review */

$this->title = Yii::t('main','Create review');
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">

    <?php Panel::begin([
        "title" => $this->title,
    ])?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php Panel::end() ?>

</div>

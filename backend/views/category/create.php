<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $modelEn common\models\CategoryEn */
/* @var $modelKz common\models\CategoryKz */

$this->title = Yii::t('default', 'CREATE_CATEGORY');
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelEn' => $modelEn,
        'modelKz' => $modelKz
    ]) ?>

</div>

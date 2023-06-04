<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelEn common\models\ProductEn */
/* @var $modelKz common\models\ProductKz */

$this->title = Yii::t('default', 'CREATE_PRODUCT');
$this->params['breadcrumbs'][] = ['label' => Yii::t('default', 'PRODUCTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelEn' => $modelEn,
        'modelKz' => $modelKz
    ]) ?>

</div>

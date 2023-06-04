<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Product;
use yii\helpers\Url;
use common\models\helpers\LanguageHelper;

$this->title = LanguageHelper::getField($model, 'title');
?>
<div class="col-xs-12">
    <a href="<?= Url::to(['/']) ?>"><?= Yii::t('app', 'Category') ?></a>
    <?php foreach ($categories as $category): ?>
        >
        <a href="<?= Url::to(['/site/category-search', 'id' => $category['id']]) ?>">
            <?= $category['title'] ?>
        </a>
    <?php endforeach; ?>
</div>
<div class="col-xs-12">
    <h1><b><?= LanguageHelper::getField($model, 'title') ?></b></h1>
    <div class="col-xs-12 col-md-8 col-lg-6 w-center">
        <div class="hidden-xs hidden-sm">
            <?php if ($model['images']): ?>
                <div class="left" style="width: 116px; height: 579px; overflow: hidden;">
                    <div class="slick-vertical">
                        <?php foreach ($model['images'] as $key=>$image): ?>
                        <?php //if ($key != 0): ?>
                            <div class="alternate-img">
                                <img src="data:image/png;base64,<?= $image ?>">
                            </div>
                        <?php //endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="main-img">
                <img src="data:image/png;base64,<?= $model['images'][0] ?>">
            </div>
        </div>
        <div class="hidden-md hidden-lg">
            <div class="sim-slider">
                <ul class="sim-slider-list books">
                    <li class="sim-slider-element">
                        <img src="data:image/png;base64,<?= $model['images'][0] ?>" alt="<?= $i = 0 ?>">
                    </li>
                    <?php foreach ($model['images'] as $key=>$image): ?>
                    <?php if ($key != 0): ?>
                        <li class="sim-slider-element"><img src="data:image/png;base64,<?= $image ?>"
                                                            alt="<?= $i++ ?>"></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <div class="sim-slider-arrow-left"></div>
                <div class="sim-slider-arrow-right"></div>
                <div class="col-xs-12">
                    <div class="sim-slider-dots product"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4 col-lg-6">
        <h2><?= Yii::t('app', 'Description') ?></h2>
        <p class="description"><?= LanguageHelper::getField($model, 'description') ?></p>
            <p class="price">
                <?= floor($model['price']) ?> ₸
                <!--            <sup>-->
                <!--                <span class="strikethrough">-->
                <!--                    4 250 ₸-->
                <!--                </span>-->
                <!--            </sup>-->
            </p>
            <a onclick="add(<?= $model->id ?>)" class="in-cart-button">
                <img src="/images/white-cart.png">
            </a>
    </div>
</div>
<div class="col-xs-12">
    <h1><b><?= Yii::t('app', 'Reviews') ?><sup><?= $reviews ? count($reviews) : 0 ?></sup></b></h1>
</div>
<div class="col-xs-12">
    <?php if ($reviews): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="review">
            <p>
                <b><?= $review['fio'] ?></b>
                <span><?= Yii::$app->formatter->asDatetime(strtotime($review['created_at']), 'short') ?></span>
            </p>
            <p><?= $review['content'] ?></p>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!$reviews ||count($reviews) == 0): ?>
        <p><?= Yii::t('app', 'There are no reviews... Write the first!') ?></p>
    <?php endif; ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($reviewModel, 'fio')->label(Yii::t('app', 'FIO')) ?>
    <?= $form->field($reviewModel, 'content')->textarea(['rows' => 10])->label(Yii::t('app', 'CONTENT')) ?>
    <?= $form->field($reviewModel, 'product_id')->hiddenInput(['value' => (int)Yii::$app->request->get('id')])->label(false) ?>
    <?= $form->field($reviewModel, 'status')->hiddenInput(['value' => Product::STATUS_ACTIVE])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Leave a review'), ['class' => 'review-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
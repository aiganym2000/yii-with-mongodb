<?php

use common\models\Category;
use common\models\helpers\LanguageHelper;
use common\models\Product;
use common\models\Slider;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Shop';
?>
    <div class="col-xs-12">
        <?php if (isset($categories)): ?>
            <a href="<?= Url::to(['/']) ?>"><?= Yii::t('app', 'Category') ?></a>
            <?php foreach ($categories as $category): ?>
                >
                <a href="<?= Url::to(['/site/category-search', 'id' => $category['id']]) ?>">
                    <?= $category['title'] ?>
                </a>
            <?php endforeach; ?>
            <div class="col-md-12">
                <h3 class="cards-title">
                    <?= LanguageHelper::getField(Category::findOne(['id'=>(int)Yii::$app->request->get('id')]), 'title', 'category') ?>
                    :
                </h3>
            </div>
        <?php else: ?>
            <h3 class="cards-title">
                <?= $search ?>:
            </h3>
        <?php endif; ?>
    </div>
<?php if (!$products) {
    echo Yii::t('app', 'Nothing found');
} ?>
<?php foreach ($products as $product): ?>
    <a href="<?= Url::to(['/site/product', 'id' => $product['id']]) ?>">
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="card">
                <div class="cart search-cart height border">
                    <div style='background-image: url("<?= Url::to(Product::getImgPath() . $product['images'][0]) ?>");'>
                    </div>
                    <div class="card-div">
                        <p><?= LanguageHelper::getField($product, 'title') ?></p>
                        <div class="card-price">
                                <span><?= ceil($product['price']) ?> ₸</span>
                                <span class="end">
                                            <a onclick="add(<?= $product['id'] ?>)">
                                                <span class="cart-img"><img src="/images/white-cart.png"></span>
                                            </a>
                                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; ?>
    <div class="col-xs-12">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'activePageCssClass' => 'active-pagination',
            'nextPageLabel' => Yii::t('app', 'Forward >'),
            'prevPageLabel' => Yii::t('app', '< Back'),
            'disabledPageCssClass' => 'active-pagination'
        ]); ?>
    </div>
<?php if ($slidersBottom): ?>
    <div id="slider-bottom">
        <div class="sim-slider">
            <div class="col-xs-12 bottom-arrows">
                <div class="sim-slider-arrow-left"><img src="/images/up.svg" class="right"></div>
                <div class="sim-slider-arrow-right"><img src="/images/down.svg" class="right"></div>
            </div>
            <ul class="sim-slider-list">
                <?php foreach ($slidersBottom as $slider): ?>
                    <li class="sim-slider-element col-xs-12">
                        <?php foreach ($slider as $s): ?>
                            <img src="<?= Url::to(Slider::getImgPath() . $s['image']) ?>" alt="<?= $s['title'] ?>"
                                 class="col-md-6">
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
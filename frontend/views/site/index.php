<?php

/* @var $this yii\web\View */

use common\models\Category;
use common\models\helpers\LanguageHelper;
use common\models\Product;
use common\models\Slider;
use yii\helpers\Url;

$this->title = 'Shop';
?>
<?php if ($slidersTop): ?>
    <div id="slider-top">
        <div class="sim-slider hidden-xs hidden-sm">
            <ul class="sim-slider-list">
                <?php foreach ($slidersTop as $slider): ?>
                    <li class="sim-slider-element"><img
                                src="<?= Url::to(Slider::getImgUrl($slider['image'])) ?>"
                                alt="<?= $slider['title'] ?>"></li>
                <?php endforeach; ?>
            </ul>
            <div class="sim-slider-arrow-left"></div>
            <div class="sim-slider-arrow-right"></div>
            <div class="sim-slider-dots"></div>
        </div>
    </div>
<?php endif; ?>
<?php if ($toys): ?>
    <div class="col-md-12">
        <h3 class="cards-title">
            <?= $categoryTitle ?>:
        </h3>
    </div>
    <div class="slider-first col-xs-12">
        <div class="slider">
            <div class="slider__wrapper">
                <?php foreach ($toys as $toy): ?>
                    <a href="<?= Url::to(['/site/product', 'id' => $toy['id']]) ?>">
                        <div class="slider__item">
                            <div class="card">
                                <div class="cart search-cart height border">
                                    <div style='background-image: url("<?= Url::to(Product::getImgPath() . $toy['images'][0]) ?>");'>
                                    </div>
                                    <div class="card-div">
                                        <p><?= LanguageHelper::getField($toy, 'title') ?></p>
                                        <div class="card-price">
                                                <span><?= ceil($toy['price']) ?> ₸</span>
                                                <span class="end">
                                            <a onclick="add(<?= $toy['id'] ?>)">
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
            </div>
        </div>
        <a class="slider__control slider__control_left" href="#" role="button"></a>
        <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
    </div>
<?php endif; ?>
<?php if ($categories): ?>
    <div class="col-xs-12 category-title">
        <?= Yii::t('app', 'Categories') ?>
    </div>
    <div class="category col-xs-12">
        <?php foreach ($categories as $key => $category): ?>
            <div class="col-xs-6 col-md-4">
                <a href="<?= Url::to(['/site/category-search', 'id' => $category['id']]) ?>">
                    <div class="<?= $colorArray[$key] ?>-category"
                         style="background-image: url('<?= Url::to(Category::getImg() . $category['img']) ?>')">
                        <h2><?= LanguageHelper::getField($category, 'title', 'category') ?></h2>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($newProducts): ?>
    <div class="col-xs-12">
        <h3 class="cards-title">
            <?= Yii::t('app', 'New products') ?>:
        </h3>
    </div>
    <div class="slider-second col-xs-12">
        <div class="slider">
            <div class="slider__wrapper">
                <?php foreach ($newProducts as $newProduct): ?>
                    <div class="slider__item">
                        <div class="card">
                            <div class="cart search-cart height border">
                                <a href="<?= Url::to(['/site/product', 'id' => $newProduct['id']]) ?>">
                                    <div style='background-image: url("<?= Url::to(Product::getImgPath() . $newProduct['images'][0]) ?>");'>
                                    </div>
                                    <div class="card-div">
                                        <p><?= LanguageHelper::getField($newProduct, 'title') ?></p>
                                        <div class="card-price">
                                                <span><?= ceil($newProduct['price']) ?> ₸</span>
                                                <span class="end">
                                            <a onclick="add(<?= $newProduct['id'] ?>)">
                                                <span class="cart-img"><img src="/images/white-cart.png"></span>
                                            </a>
                                        </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <a class="slider__control slider__control_left" href="#" role="button"></a>
        <a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
    </div>
<?php endif; ?>
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
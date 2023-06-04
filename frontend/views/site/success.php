<?php

use common\models\pay\KassanovaPay;

$this->title = 'Shop';
?>
<p class="information">
    <?= Yii::t('app', 'Thank you for ordering! You will be contacted soon') ?>.
        <?= Yii::t('app', 'Your order №') . $orderId ?>
</p>
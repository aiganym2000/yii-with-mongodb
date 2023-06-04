<?php
use common\models\Product;
use common\models\Order;
?>

Спасибо за покупку, <?= $order['last_name'] ?> <?= $order['first_name'] ?>!<br>
Ваш заказ №<?= $order['id'] ?><br>
Вы заказали:
<?php foreach ($order['order_item'] as $oi): ?>
    <?= Product::findOne(['id' => (int)$oi['id']])['title'] ?> <?= $oi['count'] ?> x <?= ceil(Product::findOne(['id' => (int)$oi['id']])['price']) ?> тг
    <br>
<?php endforeach; ?>
Ваши данные:<br>
Телефон: <?= $order['phone'] ?><br>
Адрес: <?= $order['address'] ?><br>
Общая сумма: <?= ceil($order['full_amount']) ?> тг<br>
Оплата <?php if ($order['payment_type'] == Order::PAYMENT_TYPE_BY_CASH) echo 'наличными'; else echo 'картой' ?>

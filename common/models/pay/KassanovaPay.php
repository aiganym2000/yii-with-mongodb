<?php

namespace common\models\pay;

use Yii;

//Документация
//https://pay.alfabank.kz/ecommerce/instructions/Merchant%20Manual%20(RU).pdf
class KassanovaPay
{
    //Запрос регистрации заказа
    /*
     * amount=100&
     * currency=643&
     * language=ru&
     * orderNumber=87654321&
     * returnUrl=https://server/applicaton_context/finish.html&
     * jsonParams={"orderNumber":1234567890}
     * &pageView=DESKTOP&
     * expirationDate=2014-09-08T14:14:14&
     * merchantLogin=merch_child&
     * features=AUTO_PAYMENT
     * */
    public static function register($orderNumber, $amount, $currency = null, $description = null, $language = null,
                                    $pageView = null, $clientId = null, $merchantLogin = null, $jsonParams = null,
                                    $sessionTimeoutSecs = null, $bindingId = null, $features = null)
    {
        $query = 'register.do';
        $returnUrl = Yii::$app->params['kassanova']['return_url'];
        $failUrl = Yii::$app->params['kassanova']['fail_url'];
        $params = [
            'orderNumber' => $orderNumber,
            'amount' => $amount * 100,
            'returnUrl' => $returnUrl,
            'currency' => $currency,
            'failUrl' => $failUrl,
            'description' => $description,
            'language' => $language,
            'pageView' => $pageView,
            'clientId' => $clientId,
            'merchantLogin' => $merchantLogin,
            'jsonParams' => $jsonParams,
            'sessionTimeoutSecs' => $sessionTimeoutSecs,
            'bindingId' => $bindingId,
            'features' => $features
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос отмены оплаты заказа
    /*
     * ?language=ru&
     * orderId=9231a838-ac68-4a3e-bddb-d9781433d852
     * */
    public static function reverse($orderId, $language = null)
    {
        $query = 'reverse.do';
        $params = [
            'orderId' => $orderId,
            'language' => $language
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос возврата средств оплаты заказа
    /*
     * amount=500&
     * currency=643&
     * language=ru&
     * orderId=5e97e3fd-1d20-4b4b-a542-f5995f5e8208
     * */
    public static function refund($orderId, $amount)
    {
        $query = 'refund.do';
        $params = [
            'orderId' => $orderId,
            'amount' => $amount
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос состояния заказа
    /*
     * orderId=b8d70aa7-bfb3-4f94-b7bb-aec7273e1fce&
     * language=ru&
     * */
    public static function getOrderStatus($orderId, $language = null)
    {
        $query = 'getOrderStatus.do';
        $params = [
            'orderId' => $orderId,
            'language' => $language
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Расширенный запрос состояния заказа
    /*
     * orderId=b9054496-c65a-4975-9418-1051d101f1b9&
     * language=ru&
     * merchantOrderNumber=0784sse49d0s134567890
     * */
    public static function getOrderStatusExtended($orderId = null, $orderNumber = null, $language = null)
    {
        $query = 'getOrderStatusExtended.do';
        $params = [
            'orderNumber' => $orderNumber,
            'orderId' => $orderId,
            'language' => $language
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос проверки вовлечённости карты в 3DS
    /*
     * pan=4111111111111111
     * */
    public static function verifyEnrollment($pan)
    {
        $query = 'verifyEnrollment.do';
        $params = [
            'pan' => $pan
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос статистики по платежам за период
    /*
     * language=ru&
     * page=0&
     * size=100&
     * from=20141009160000&
     * to=20141111000000&
     * transactionStates=DEPOSITED,REVERSED&
     * merchants=SevenEightNine&
     * searchByCreatedDate=false
     * */
    public static function getLastOrdersForMerchants($size, $from, $to, $transactionStates, $merchants,
                                                     $language = null, $page = null, $searchByCreatedDate = null)
    {
        $query = 'getLastOrdersForMerchants.do';
        $params = [
            'size' => $size,
            'from' => $from,
            'to' => $to,
            'transactionStates' => $transactionStates,
            'merchants' => $merchants,
            'page' => $page,
            'language' => $language,
            'searchByCreatedDate' => $searchByCreatedDate
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос регистрации заказа c предавторизацией
    /*
     * ?amount=100&
     * currency=643&
     * language=ru&
     * orderNumber=87654321&
     * password=password&
     * returnUrl=https://server/applicaton_context/finish.html&
     * userName=userName&
     * pageView=MOBILE&
     * expirationDate=2014-09-08T14:14:14&
     * merchantLogin=merch_child&
     * features=AUTO_PAYMENT
     */
    public static function registerPreAuth($orderNumber, $amount, $currency = null, $description = null,
                                           $language = null, $pageView = null, $clientId = null, $merchantLogin = null,
                                           $jsonParams = null, $sessionTimeoutSecs = null, $bindingId = null,
                                           $features = null)
    {
        $query = 'registerPreAuth.do';
        $returnUrl = Yii::$app->params['kassanova']['returnUrl'];
        $failUrl = Yii::$app->params['kassanova']['failUrl'];
        $params = [
            'orderNumber' => $orderNumber,
            'amount' => $amount,
            'returnUrl' => $returnUrl,
            'currency' => $currency,
            'failUrl' => $failUrl,
            'description' => $description,
            'language' => $language,
            'pageView' => $pageView,
            'clientId' => $clientId,
            'merchantLogin' => $merchantLogin,
            'jsonParams' => $jsonParams,
            'sessionTimeoutSecs' => $sessionTimeoutSecs,
            'bindingId' => $bindingId,
            'features' => $features
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Запрос завершения oплаты заказа
    /*
     * ?amount=100&
     * currency=810&
     * language=ru&
     * orderId=e5b59d3d-746b-4828-9da4-06f126e01b68&
     */
    public static function deposit($orderId, $amount)
    {
        $query = 'deposit.do';
        $params = [
            'orderId' => $orderId,
            'amount' => $amount
        ];
        $json = self::query($query, $params);
        return $json;
    }

    //Построитель запросов
    /*
     * Коды ошибок
     * 0 Обработка запроса прошла без системных ошибок
     * 1 Заказ с таким номером уже зарегистрирован в системе
     * 2 Заказ отклонен по причине ошибки в реквизитах платежа
     * 3 Неизвестная (запрещенная) валюта
     * 4 Отсутствует обязательный параметр запроса
     * 5 Ошибка значение параметра запроса
     * 6 Незарегистрированный OrderId
     * 7 Системная ошибка
     */
    private static function query($query, $params)
    {
        $queryParams = '';
        foreach ($params as $key => $value) {
            if ($value != null) {
                $queryParams = $queryParams . '&' . $key . '=' . $value;
            }
        }
        $json = Yii::$app->params['kassanova']['url'] . $query . '?userName=' . Yii::$app->params['kassanova']['api']
            . '&password=' . Yii::$app->params['kassanova']['api_pass'] . $queryParams;
        $json = file_get_contents($json);
        $json = json_decode($json);
        return $json;
    }
}
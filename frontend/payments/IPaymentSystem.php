<?php

namespace frontend\payments;

use common\models\Order;

interface IPaymentSystem
{

    /**
     * @param Order $order
     * @return string
     */
    public function checkout($order);

    /**
     * @param $posData
     * @return mixed
     */
    public function handleCallback($posData);


}
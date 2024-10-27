<?php

require '../config/function.php';

$paramResult = checkParamId('index');
if (is_numeric($paramResult)) {

    $indexValue = validate($paramResult);

    if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {

        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);

        redirect('order-create.php', 'Bidhaa Imeondolewa');
    } else {

        redirect('order-create.php', 'Hakuna Bidhaa');
    }
} else {
    redirect('order-create.php', 'param not numeric');
}

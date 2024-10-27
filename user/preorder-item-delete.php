<?php

require '../config/function.php';

$paramResult = checkParamId('index');
if (is_numeric($paramResult)) {

    $indexValue = validate($paramResult);

    if (isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])) {

        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);

        redirect('preorder-create.php', 'Bidhaa Imeondolewa');
    } else {

        redirect('preorder-create.php', 'Hakuna Bidhaa');
    }
} else {
    redirect('preorder-create.php', 'param not numeric');
}

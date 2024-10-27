<?php

include('../config/function.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}


if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if ($checkProduct) {

        if (mysqli_num_rows($checkProduct) > 0) {

            $row = mysqli_fetch_assoc($checkProduct);
            if ($row['quantity'] < $quantity) {
                redirect('loan-create.php', 'Only ' . $row['quantity'] . ' quantity available!');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'quantity' => $quantity, // hapa
                'measure' => $row['measure'],
                'sell_price' => $row['sell_price'],
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {

                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);
            } else {

                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $prodSessionItem['quantity'] + $quantity;
                        $newPrice = $prodSessionItem['sell_price'] + $price;

                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'quantity' => $newQuantity,
                            'measure' => $row['measure'],
                            'sell_price' => $row['sell_price'],
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }

            redirect('loan-create.php', 'Bidhaa imechaguliwa: ' . $row['name']);
        } else {

            redirect('loan-create.php', 'Hakuna Bidhaa Hiyo!');
        }
    } else {
        redirect('loan-create.php', 'Something Went Wrong!');
    }
}


if (isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if ($flag) {

        jsonResponse(200, 'success', 'Idadi imebadilishwa');
    } else {

        jsonResponse(500, 'error', 'Something Went Wrong. Please re-fresh');
    }
}


if (isset($_POST['proceedToPlaceBtn'])) {
    $name = validate($_POST['cname']);
    $destination = validate($_POST['destination']);
    $amount_paid = validate($_POST['amount_paid']);
    $comment = validate($_POST['comment']);

    // Checking for Customer
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' LIMIT 1");
    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV-" . rand(111111, 999999);
            $_SESSION['cname'] = $name;
            $_SESSION['destination'] = $destination;
            $_SESSION['amount_paid'] = $amount_paid;
            $_SESSION['comment'] = $comment;

            jsonResponse(200, 'success', 'Customer Found');
        } else {
            $_SESSION['cname'] = $name;
            jsonResponse(404, 'warning', 'Ongeza Mteja');
        }
    } else {
        jsonResponse(500, 'error', 'Something Went Wrong');
    }
}


if (isset($_POST['saveCustomerBtn'])) {
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);

    if ($name != '') {

        $data = [
            'name' => $name,
            'phone' => $phone,
        ];
        $result = insert('customers', $data);
        if ($result) {

            jsonResponse(200, 'success', 'Mteja Amesajiliwa');
        } else {
            jsonResponse(500, 'error', 'Something Went Wrong');
        }
    } else {
        jsonResponse(422, 'warning', 'Jaza Taarifa za Mteja');
    }
}


if (isset($_POST['saveOrder'])) {
    $name = validate($_SESSION['cname']);
    $destination = validate($_SESSION['destination']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $amount_paid = validate($_SESSION['amount_paid']);
    $comment = validate($_SESSION['comment']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];


    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' LIMIT 1");
    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Something Went Wrong!');
    }

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'warning', 'No Items to place order!');
        }

        $sessionProducts = $_SESSION['productItems'];


        $totalAmount = 0;
        foreach ($sessionProducts as $amtItem) {
            $totalAmount += $amtItem['sell_price'] * $amtItem['quantity'];
        }

        if (($totalAmount >= $amount_paid)) {
            $amount_due = $totalAmount - $amount_paid;
            $amount_surplus = 0;
        } else {
            $amount_due = 0;
            $amount_surplus = $amount_paid - $totalAmount;
        }

        //Checking status
        if ($totalAmount <= $amount_paid) {
            $order_status = "Amelipa";
        } else {
            $order_status = "Anadaiwa";
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(11111, 99999),
            'invoice_no' => $invoice_no,
            'destination' => $destination,
            'total_amount' => $totalAmount,
            'paid_amount' => $amount_paid,
            'due_amount' => $amount_due,
            'surplus_amount' => $amount_surplus,
            'order_date' => date('Y-m-d'),
            'order_status' => $order_status,
            'comment' => $comment,
            'order_placed_by_id' => $order_placed_by_id
        ];

        $result = insert('loans', $data);

        $lastOrderId = mysqli_insert_id($conn);

        foreach ($sessionProducts as $prodItem) {

            $productId = $prodItem['product_id'];
            $price = $prodItem['sell_price'];
            $quantity = $prodItem['quantity'];

            // Inserting order items
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            ];

            $orderItemQuery = insert('loan_items', $dataOrderItem);

            // Checking for the books quantity and decreasing quantity and making total Quantity
            $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity = $productQtyData['quantity'] - $quantity;

            $dataUpdate = [
                'quantity' => $totalProductQuantity
            ];
            $updateProductQty = update('products', $productId, $dataUpdate);
        }

        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cname']);
        unset($_SESSION['destination']);
        unset($_SESSION['invoice_no']);

        jsonResponse(200, 'success', 'Order Placed Successfully');
    } else {
        jsonResponse(404, 'werning', 'No Customer Found!');
    }
}

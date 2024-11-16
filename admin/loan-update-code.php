<?php
include('../config/function.php');

if (isset($_POST['updateOrder'])) {

    $amount_paid_new = validate($_POST['amount_paid']);
    $comment = validate($_POST['comment']);
    $orderId = validate($_POST["order_id"]);


    if (!is_numeric($amount_paid_new) || $amount_paid_new <= 0) {
        redirect("loan-update.php?track=" . $orderData["tracking_no"], "Invalid amount entered.");
    }

    //loan order from loans table
    $stmt = $conn->prepare("SELECT * FROM loans WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orders = $stmt->get_result();

    //loan order items from loan_items table
    $stmt = $conn->prepare("SELECT * FROM loan_items WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result();

    if ($orders->num_rows > 0) {
        //get loan order data
        $orderData = $orders->fetch_assoc();

        // get loan items data
        $orderItems = $items->fetch_all(MYSQLI_ASSOC);

        $customer_id = $orderData["customer_id"];
        $tracking_no = $orderData["tracking_no"];
        $invoice_no = $orderData["invoice_no"];
        $amount_total = $orderData["total_amount"];
        $amount_paid = $orderData["paid_amount"];
        $amount_due = $orderData["due_amount"];
        $amount_surplus = $orderData["surplus_amount"];
        $loan_amount = $orderData["loan_payment"];
        $salary_amount = $orderData["salary_payment"];
        $other_amount = $orderData["other_payment"];
        $amount1 = $orderData["amount1"];
        $amount2 = $orderData["amount2"];
        $amount3 = $orderData["amount3"];
        $order_date = $orderData["order_date"];
        $order_status = $orderData["order_status"];
        $order_placed_by_id = $orderData["order_placed_by_id"];


        // Unyama
        $amount_paid = $amount_paid + $amount_paid_new;
        $amount_due = $amount_total - $amount_paid;

        $loanPayment = ($amount_paid * $amount1) / $amount_total;
        $salaryPayment = ($amount_paid * $amount2) / $amount_total;
        $otherPayment = ($amount_paid * $amount3) / $amount_total;

        // Update order status based on payment
        if ($amount_total == $amount_paid) {
            $order_status = "Amelipa";

            //insert into orders
            $data = [
                'customer_id' => $customer_id,
                'tracking_no' => $tracking_no,
                'invoice_no' => $invoice_no,
                'total_amount' => $amount_total,
                'paid_amount' => $amount_paid,
                'due_amount' => $amount_due,
                'surplus_amount' => $amount_surplus,
                'loan_payment' => $loanPayment,
                'salary_payment' => $salaryPayment,
                'other_payment' => $otherPayment,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'comment' => $comment,
                'order_placed_by_id' => $order_placed_by_id,
            ];

            $result = insert('orders', $data);

            // getting new order id from orders table after inserting
            $new_order_id = mysqli_insert_id($conn);

            foreach ($orderItems as $item) {
                $item_id = $item['id'];
                $order_id = $item['order_id'];
                $product_id = $item['product_id'];
                $price = $item['price'];
                $quantity = $item['quantity'];

                // Inserting order items
                $data_items = [
                    'order_id' => $new_order_id,
                    'product_id' => $product_id,
                    'price' => $price,
                    'quantity' => $quantity,
                ];

                $result_items = insert('order_items', $data_items);

                delete('loan_items', $item_id);
            }


            //delete from loans
            delete("loans", $orderId);

            // Check the result of the update function
            if ($result) {
                redirect('orders.php', 'Mkopo Umekamilika');
            } else {
                redirect('orders.php', 'Something went wrong!');
            }
        } else {
            $order_status = "Anadaiwa";

            $data = [
                'paid_amount' => $amount_paid,
                'due_amount' => $amount_due,
                'loan_payment' => $loanPayment,
                'salary_payment' => $salaryPayment,
                'other_payment' => $otherPayment,
                'order_status' => $order_status,
                'comment' => $comment
            ];

            $result = update('loans', $orderId, $data);

            if ($result) {
                redirect('loan-update.php?track=' . $orderData["tracking_no"], 'Mkopo Umesahihishwa');
            } else {
                redirect('loan-update.php?track=' . $orderData["tracking_no"], 'Something went wrong!');
            }
        }
    } else {
        redirect('loan-update.php?track=' . $orderData["tracking_no"], 'Fill all required fields');
    }

    $stmt->close();
}

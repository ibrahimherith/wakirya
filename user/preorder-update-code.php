<?php
include('../config/function.php');

if (isset($_POST['updateOrder'])) {

    // Assuming validate() properly sanitizes input
    $amount_paid_new = validate($_POST['amount_paid']);
    $comment = validate($_POST['comment']);
    $orderId = validate($_POST["order_id"]);


    // Check if amount_paid is numeric
    if (!is_numeric($amount_paid_new) || $amount_paid_new <= 0) {
        redirect("preorder-update.php?track=" . $orderData["tracking_no"], "Invalid amount entered.");
    }

    // Use prepared statements to avoid SQL Injection
    $stmt = $conn->prepare("SELECT * FROM preorders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orders = $stmt->get_result();

    //loan order items from loan_items table
    $stmt = $conn->prepare("SELECT * FROM preorder_items WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result();

    if ($orders->num_rows > 0) {
        $orderData = $orders->fetch_assoc();

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
        $order_date = $orderData["order_date"];
        $order_status = $orderData["order_status"];
        $order_placed_by_id = $orderData["order_placed_by_id"];

        // get loan items data
        $orderItems = $items->fetch_assoc();

        $item_id = $orderItems['id'];
        $order_id = $orderItems['order_id'];
        $product_id = $orderItems['product_id'];
        $price = $orderItems['price'];
        $quantity = $orderItems['quantity'];

        // 
        $amount_paid = $amount_paid + $amount_paid_new;

        // Calculate the new amount due
        $amount_due = $amount_total - $amount_paid;

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
                'loan_payment' => $loan_amount,
                'salary_payment' => $salary_amount,
                'other_payment' => $other_amount,
                'order_date' => $order_date,
                'order_status' => $order_status,
                'comment' => $comment,
                'order_placed_by_id' => $order_placed_by_id,
            ];

            $result = insert('orders', $data);

            // getting new order id from orders table after inserting
            $new_order_id = mysqli_insert_id($conn);

            // Inserting order items
            $data_items = [
                'order_id' => $new_order_id,
                'product_id' => $product_id,
                'price' => $price,
                'quantity' => $quantity,
            ];

            $result_items = insert('order_items', $data_items);

            //delete from loans
            delete("preorders", $orderId);
            delete("preorder_items", $item_id);

            // Check the result of the update function
            if ($result) {
                redirect('orders.php', 'Oda Imekamilika');
            } else {
                redirect('orders.php', 'Something went wrong!');
            }
        } else {
            $order_status = "Anadaiwa";

            $data = [
                'paid_amount' => $amount_paid,
                'due_amount' => $amount_due,
                'order_status' => $order_status,
                'comment' => $comment
            ];

            $result = update('preorders', $orderId, $data);

            if ($result) {
                redirect('preorder-update.php?track=' . $orderData["tracking_no"], 'Oda Imesahihishwa');
            } else {
                redirect('preorder-update.php?track=' . $orderData["tracking_no"], 'Something went wrong!');
            }
        }
    } else {
        redirect('preorder-update.php?track=' . $orderData["tracking_no"], 'Fill all required fields');
    }

    $stmt->close();
}

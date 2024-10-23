<?php
include('../config/function.php');

if (isset($_POST['updateOrder'])) {

    // Assuming validate() properly sanitizes input
    $amount_paid_new = validate($_POST['amount_paid']);
    $comment = validate($_POST['comment']);
    $orderId = validate($_POST["order_id"]);


    // Check if amount_paid is numeric
    if (!is_numeric($amount_paid_new) || $amount_paid_new <= 0) {
        redirect("order-update.php?track=" . $orderData["tracking_no"], "Invalid amount entered.");
    }

    // Use prepared statements to avoid SQL Injection
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orders = $stmt->get_result();

    if ($orders->num_rows > 0) {
        $orderData = $orders->fetch_assoc();

        $amount_total = $orderData["total_amount"];
        $amount_paid = $orderData["paid_amount"];
        $amount_due = $orderData["due_amount"];
        $order_status = $orderData["order_status"];


        $amount_paid = $amount_paid + $amount_paid_new;

        // Calculate the new amount due
        $amount_due = $amount_total - $amount_paid;

        // Update order status based on payment
        if ($amount_total == $amount_paid) {
            $order_status = "Amelipa";
        } else {
            $order_status = "Anadaiwa";
        }

        // Create the data array
        $data = [
            'paid_amount' => $amount_paid,
            'due_amount' => $amount_due,
            'order_status' => $order_status,
            'comment' => $comment
        ];

        // Call the update function (ensure this is defined)
        $result = update('orders', $orderId, $data);

        // Check the result of the update function
        if ($result) {
            redirect('order-update.php?track=' . $orderData["tracking_no"], 'Order Updated Successfully');
        } else {
            redirect('order-update.php?track=' . $orderData["tracking_no"], 'Something went wrong!');
        }
    } else {
        redirect('order-update.php?track=' . $orderData["tracking_no"], 'Fill all required fields');
    }

    $stmt->close();
}

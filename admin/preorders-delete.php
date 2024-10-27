<?php
require '../config/function.php';

if (isset($_GET['track'])) {
    $trackingNo = mysqli_real_escape_string($conn, $_GET['track']);

    // First, get the order_id of the order to be deleted
    $getOrderIdQuery = "SELECT id FROM preorders WHERE tracking_no = '$trackingNo'";
    $getOrderIdResult = mysqli_query($conn, $getOrderIdQuery);

    if ($getOrderIdResult && mysqli_num_rows($getOrderIdResult) > 0) {
        $orderData = mysqli_fetch_assoc($getOrderIdResult);
        $orderId = $orderData['id']; // Get the order_id

        // Delete the order from the orders table
        $deleteOrderQuery = "DELETE FROM preorders WHERE id = '$orderId'";
        $deleteOrderResult = mysqli_query($conn, $deleteOrderQuery);

        if ($deleteOrderResult) {
            // Now, delete associated items from the order_items table using the order_id
            $deleteOrderItemsQuery = "DELETE FROM preorder_items WHERE order_id = '$orderId'";
            $deleteOrderItemsResult = mysqli_query($conn, $deleteOrderItemsQuery);

            if ($deleteOrderItemsResult) {
                $_SESSION['message'] = "Order and its items deleted successfully.";
                header("Location: preorders.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Failed to delete order items.";
                header("Location: preorders.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Failed to delete order.";
            header("Location: preorders.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Order not found.";
        header("Location: preorders.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: preorders.php");
    exit(0);
}

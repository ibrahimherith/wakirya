<?php
require '../config/function.php';

if (isset($_GET['track'])) {
    $trackingNo = mysqli_real_escape_string($conn, $_GET['track']);

    // First, get the order_id of the order to be deleted
    $getOrderIdQuery = "SELECT id FROM loans WHERE tracking_no = '$trackingNo'";
    $getOrderIdResult = mysqli_query($conn, $getOrderIdQuery);

    if ($getOrderIdResult && mysqli_num_rows($getOrderIdResult) > 0) {
        $orderData = mysqli_fetch_assoc($getOrderIdResult);
        $orderId = $orderData['id']; // Get the order_id

        // Delete the order from the orders table
        $deleteOrderQuery = "DELETE FROM loans WHERE id = '$orderId'";
        $deleteOrderResult = mysqli_query($conn, $deleteOrderQuery);

        if ($deleteOrderResult) {
            // Now, delete associated items from the order_items table using the order_id
            $deleteOrderItemsQuery = "DELETE FROM loan_items WHERE order_id = '$orderId'";
            $deleteOrderItemsResult = mysqli_query($conn, $deleteOrderItemsQuery);

            if ($deleteOrderItemsResult) {
                $_SESSION['message'] = "Loan and its items deleted successfully.";
                header("Location: loans.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Failed to delete loan items.";
                header("Location: loans.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Failed to delete loan.";
            header("Location: loans.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Loan not found.";
        header("Location: loans.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: loans.php");
    exit(0);
}

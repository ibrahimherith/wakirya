<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Taarifa za Mauzo
                <a href="orders-view-print.php?track=<?= $_GET['track'] ?>" class="btn btn-info mx-2 btn-sm float-end">Print / Download Receipt</a>
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php
            if (isset($_GET['track'])) {
                if ($_GET['track'] == '') {
            ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Number Found</h5>
                        <div>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25">Back</a>
                        </div>
                    </div>
                    <?php
                    return false;
                }

                $trackingNo = validate($_GET['track']);

                $query = "SELECT o.*, c.* FROM orders o, customers c 
                                WHERE c.id = o.customer_id AND tracking_no='$trackingNo' 
                                ORDER BY o.id DESC";

                $orders = mysqli_query($conn, $query);
                if ($orders) {
                    if (mysqli_num_rows($orders) > 0) {

                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];

                    ?>
                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Mauzo</h5>
                                    <label class="mb-1">
                                        Tarehe:
                                        <span class="fw-bold"><?= $orderData['order_date']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Status:
                                        <span class="fw-bold"><?= $orderData['order_status']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Jumla:
                                        <span class="fw-bold"><?= number_format($orderData['total_amount'], 2); ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Maoni:
                                        <span class="fw-bold"><?= $orderData['comment']; ?></span>
                                    </label>
                                    <br />
                                </div>
                                <div class="col-md-6">
                                    <h5>Mteja</h5>
                                    <label class="mb-1">
                                        Jina:
                                        <span class="fw-bold"><?= $orderData['name']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Simu Na.:
                                        <span class="fw-bold"><?= $orderData['phone']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Amelipa:
                                        <span class="fw-bold"><?= number_format($orderData['paid_amount'], 2); ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Anapokwenda:
                                        <span class="fw-bold"><?= $orderData['destination']; ?></span>
                                    </label>
                                    <br />
                                </div>
                            </div>
                        </div>


                        <?php
                        $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* 
                                    FROM orders as o, order_items as oi, products as p
                                    WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.tracking_no='$trackingNo'";

                        $orderItemsRes = mysqli_query($conn, $orderItemQuery);
                        if ($orderItemsRes) {
                            if (mysqli_num_rows($orderItemsRes) > 0) {
                        ?>
                                <h5 class="my-3">Bidhaa</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Jina</th>
                                                <th class="text-center">Bei</th>
                                                <th class="text-center">Idadi</th>
                                                <th class="text-center">Jumla (Bei)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orderItemsRes as $orderItemRow) : ?>
                                                <tr>
                                                    <td>
                                                        <?= $orderItemRow['name']; ?>
                                                    </td>
                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= number_format($orderItemRow['orderItemPrice'], 0) ?>
                                                    </td>
                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= $orderItemRow['orderItemQuantity']; ?>
                                                    </td>
                                                    <td width="15%" class="fw-bold text-center">
                                                        <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'], 0) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                            <tr>
                                                <td class="fw-bold">Jumla ya Gharama: </td>
                                                <td colspan="3" class="text-end px-5 fw-bold">TSh. <?= number_format($orderItemRow['total_amount'], 0); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        <?php
                            } else {
                                echo '<h5>Something Went Wrong!</h5>';
                                return false;
                            }
                        } else {
                            echo '<h5>Something Went Wrong!</h5>';
                            return false;
                        }
                        ?>


                <?php
                    } else {
                        echo '<h5>No Record Found!</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something Went Wrong!</h5>';
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Tracking Number Found</h5>
                    <div>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
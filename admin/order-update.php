<?php
include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Rekebisha Mauzo
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>

        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php

            if (isset($_GET['track'])) {

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
                                    <h5>Taarifa za Mauzo</h5>
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
                                        <span class="fw-bold"><?= $orderData['total_amount']; ?></span>
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
                                        Simu:
                                        <span class="fw-bold"><?= $orderData['phone']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Amelipa:
                                        <span class="fw-bold"><?= $orderData['paid_amount']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Deni:
                                        <span class="fw-bold"><?= $orderData['due_amount']; ?></span>
                                    </label>
                                    <br />
                                </div>
                            </div>
                        </div>

            <?php
                    } else {
                        echo '<h5>No record found!</h5>';
                    }
                } else {
                    echo '<h5>Something Went Wrong!</h5>';
                }
            }

            ?>


            <!--  -->

            <form action="order-update-code.php" method="POST" class="mt-3">

                <?php
                if (isset($_GET['track'])) {
                    $tracking_no = $_GET['track'];

                    $orderQuery = mysqli_query($conn, "SELECT * FROM orders WHERE tracking_no='$tracking_no'");

                    if (mysqli_num_rows($orderQuery) > 0) {
                        $orderData = mysqli_fetch_assoc($orderQuery);
                        $orderId = $orderData['id'];
                ?>

                        <input type="hidden" name="order_id" value="<?= $orderData['id']; ?>">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Kiasi alicholipa</label>
                                <input type="number" id="amount_paid" name="amount_paid" class="form-control" value="" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Maoni</label>
                                <textarea id="comment" name="comment" class="form-control" rows="2"><?= $orderData['comment']; ?></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <br />
                                <button type="submit" value="<?= $orderId; ?>" name="updateOrder" class="btn btn-success w-100">Rekebisha</button>
                            </div>
                        </div>

                <?php

                    } else {
                        echo '<h5>No record found!</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something Went Wrong chini!</h5>';
                    return false;
                }
                ?>

            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
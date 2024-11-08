<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Oda</h4>
                </div>
                <!-- Search Input -->
                <div class="col-md-4 offset-md-4">
                    <input type="text" id="preorderSearch" class="form-control" placeholder="Tafuta Oda...">
                </div>
            </div>
        </div>
        <div class="card-body">

            <?php
            // Fetch all preorders without pagination
            if (isset($_GET['date']) || isset($_GET['payment_status'])) {
                $orderDate = validate($_GET['date']);
                $paymentStatus = validate($_GET['payment_status']);

                if ($orderDate != '' && $paymentStatus == '') {
                    $query = "SELECT o.*, c.* FROM preorders o, customers c 
                              WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
                              ORDER BY o.id DESC";
                } elseif ($orderDate == '' && $paymentStatus != '') {
                    $query = "SELECT o.*, c.* FROM preorders o, customers c 
                              WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' 
                              ORDER BY o.id DESC";
                } elseif ($orderDate != '' && $paymentStatus != '') {
                    $query = "SELECT o.*, c.* FROM preorders o, customers c 
                              WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
                              AND o.payment_mode='$paymentStatus' 
                              ORDER BY o.id DESC";
                } else {
                    $query = "SELECT o.*, c.* FROM preorders o, customers c 
                              WHERE c.id = o.customer_id ORDER BY o.id DESC";
                }
            } else {
                $query = "SELECT o.*, c.* FROM preorders o, customers c 
                          WHERE c.id = o.customer_id ORDER BY o.id DESC";
            }

            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
            ?>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <!-- <th>Track No.</th> -->
                                <th>Jina la Mteja</th>
                                <!-- <th>Simu</th> -->
                                <th>Gharama</th>
                                <th>Malipo</th>
                                <th>Deni</th>
                                <th>Tarehe</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem) : ?>
                                <tr>
                                    <!-- <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td> -->
                                    <td><?= $orderItem['name']; ?></td>
                                    <!-- <td><?= $orderItem['phone']; ?></td> -->
                                    <td><?= $orderItem['total_amount']; ?></td>
                                    <td><?= $orderItem['paid_amount']; ?></td>
                                    <td><?= $orderItem['due_amount']; ?></td>
                                    <td><?= date('d M, Y', strtotime($orderItem['order_date'])); ?></td>
                                    <td><?= $orderItem['order_status']; ?></td>
                                    <td>
                                        <a href="preorders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                        <?php if ($orderItem['order_status'] == "Anadaiwa") { ?>
                                            <a href="preorder-update.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-success mb-0 px-2 btn-sm">Update</a>
                                        <?php } ?>
                                        <a href="preorders-view-print.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                        <a href="preorders-delete.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-danger mb-0 px-2 btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

            <?php
                } else {
                    echo "<h5>No Record Available</h5>";
                }
            } else {
                echo "<h5>Something Went Wrong</h5>";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
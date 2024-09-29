<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Mikopo</h4>
                </div>
                <!-- Search Input -->
                <div class="col-md-4 offset-md-4">
                    <input type="text" id="loanSearch" class="form-control" placeholder="Tafuta mikopo...">
                </div>
            </div>
        </div>
        <div class="card-body">

            <?php
            // Pagination logic
            $limit = 10; // Set the number of loans per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Count total loans
            $countQuery = "SELECT COUNT(*) as total FROM orders";
            $countResult = mysqli_query($conn, $countQuery);
            $loanCount = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($loanCount / $limit);

            if (isset($_GET['date']) || isset($_GET['payment_status'])) {
                $orderDate = validate($_GET['date']);
                $paymentStatus = validate($_GET['payment_status']);

                if ($orderDate != '' && $paymentStatus == '') {
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                              WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
                              ORDER BY o.id DESC LIMIT $start, $limit";
                } elseif ($orderDate == '' && $paymentStatus != '') {
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                              WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' 
                              ORDER BY o.id DESC LIMIT $start, $limit";
                } elseif ($orderDate != '' && $paymentStatus != '') {
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                              WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
                              AND o.payment_mode='$paymentStatus' 
                              ORDER BY o.id DESC LIMIT $start, $limit";
                } else {
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                              WHERE c.id = o.customer_id ORDER BY o.id DESC LIMIT $start, $limit";
                }
            } else {
                $query = "SELECT o.*, c.* FROM orders o, customers c 
                          WHERE c.id = o.customer_id ORDER BY o.id DESC LIMIT $start, $limit";
            }

            // if (isset($_GET['date']) || isset($_GET['payment_status'])) {
            //     $orderDate = validate($_GET['date']);
            //     $paymentStatus = validate($_GET['payment_status']);

            //     if ($orderDate != '' && $paymentStatus == '') {
            //         $query = "SELECT o.*, c.* FROM loans o, customers c 
            //                   WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
            //                   ORDER BY o.id DESC LIMIT $start, $limit";
            //     } elseif ($orderDate == '' && $paymentStatus != '') {
            //         $query = "SELECT o.*, c.* FROM loans o, customers c 
            //                   WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' 
            //                   ORDER BY o.id DESC LIMIT $start, $limit";
            //     } elseif ($orderDate != '' && $paymentStatus != '') {
            //         $query = "SELECT o.*, c.* FROM loans o, customers c 
            //                   WHERE c.id = o.customer_id AND o.order_date='$orderDate' 
            //                   AND o.payment_mode='$paymentStatus' 
            //                   ORDER BY o.id DESC LIMIT $start, $limit";
            //     } else {
            //         $query = "SELECT o.*, c.* FROM loans o, customers c 
            //                   WHERE c.id = o.customer_id ORDER BY o.id DESC LIMIT $start, $limit";
            //     }
            // } else {
            //     $query = "SELECT o.*, c.* FROM loans o, customers c 
            //               WHERE c.id = o.customer_id ORDER BY o.id DESC LIMIT $start, $limit";
            // }

            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
            ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center" id="loanTable">
                        <thead>
                            <tr>
                                <th>Track No.</th>
                                <th>Mteja</th>
                                <th>Simu Na.</th>
                                <th>Tarehe</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem) : ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                    <td><?= $orderItem['name']; ?></td>
                                    <td><?= $orderItem['phone']; ?></td>
                                    <td><?= date('d M, Y', strtotime($orderItem['order_date'])); ?></td>
                                    <td><?= $orderItem['order_status']; ?></td>
                                    <td>
                                        <a href="loans-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                        <?php if ($orderItem['order_status'] == "Anadaiwa") { ?>
                                            <a href="loan-update.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-success mb-0 px-2 btn-sm">Update</a>
                                        <?php } ?>
                                        <a href="loans-view-print.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
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

<!-- Add jQuery to handle search functionality -->
<script>
    $(document).ready(function() {
        $("#loanSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#loanTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
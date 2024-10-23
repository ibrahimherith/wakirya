<?php
include('includes/header.php');
if (!isset($_SESSION['productItems'])) {
    echo '<script> window.location.href = "preorder-create.php"; </script>';
}
?>

<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 p-4 text-center">
                    <h5 id="orderPlaceSuccessMessage"></h5>
                </div>
                <div class="text-center">
                    <a href="orders.php" class="btn btn-secondary">Close</a>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Taarifa za Mauzo
                        <a href="order-create.php" class="btn btn-danger float-end">Back</a>
                    </h5>
                </div>
                <div class="card-body">

                    <?php alertMessage(); ?>

                    <div id="myBillingArea" class="justify-items-center mx-5 p-5 ">

                        <?php
                        if (isset($_SESSION['cname'])) {
                            $name = validate($_SESSION['cname']);
                            // $phone = validate($_SESSION['cphone']);
                            $invoiceNo = validate($_SESSION['invoice_no']);

                            $customerQuery = mysqli_query($conn, "SELECT * FROM customers WHERE name='$name' LIMIT 1");
                            if ($customerQuery) {
                                if (mysqli_num_rows($customerQuery) > 0) {

                                    $cRowData = mysqli_fetch_assoc($customerQuery);
                        ?>
                                    <table style="width:100%; margin-bottom: 20px;" class="align-items-center justify-content-center">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;" colspan="2">
                                                    <img src="assets/img/wk.jpeg" alt="" width="150px" height="150px">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Mteja</h5>
                                                    <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Jina: <?= $cRowData['name'] ?> </p>
                                                    <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Simu: <?= $cRowData['phone'] ?> </p>
                                                </td>
                                                <td align="end">
                                                    <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Invoice Details</h5>
                                                    <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Namba: <?= $invoiceNo; ?> </p>
                                                    <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Tarehe: <?= date('d M Y'); ?> </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                        <?php
                                } else {
                                    echo "<h5>No Customer Found</h5>";
                                    return;
                                }
                            }
                        }
                        ?>

                        <?php
                        if (isset($_SESSION['productItems'])) {
                            $sessionProducts = $_SESSION['productItems'];
                        ?>
                            <div class="table-responsive mb-3">
                                <table style="width:100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Na.</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Jina</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Bei</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Idadi</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Jumla</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $totalAmount = 0;

                                        foreach ($sessionProducts as $key => $row) :

                                            $totalAmount += $row['sell_price'] * $row['quantity']
                                        ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['sell_price'], 0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    <?= number_format($row['sell_price'] * $row['quantity'], 0) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="4" align="start" style="font-weight: bold;">Jumla: </td>
                                            <td colspan="4"><?= number_format($totalAmount, 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="start" style="font-weight: bold;">Amelipa: </td>
                                            <td colspan="4"><?= number_format($_SESSION['amount_paid'], 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="start" style="font-weight: bold;">Anadaiwa: </td>
                                            <td colspan="4">
                                                <?php
                                                $default = 0;

                                                if ($totalAmount >= $_SESSION['amount_paid']) {
                                                    echo number_format($totalAmount - $_SESSION['amount_paid'], 0);
                                                } else {
                                                    echo number_format($default, 2);
                                                }

                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="start" style="font-weight: bold;">Anapokwenda: </td>
                                            <td colspan="4"><?= $_SESSION['destination']; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="start" style="font-weight: bold;">Maoni: </td>
                                            <td colspan="4"><?= $_SESSION['comment']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo '<h5 class="text-center">No Items added</h5>';
                        }
                        ?>

                    </div>

                    <?php if (isset($_SESSION['productItems'])) : ?>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder">Save</button>
                            <a href="order-create.php" class="btn btn-warning px-4 mx-1">Cancel</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
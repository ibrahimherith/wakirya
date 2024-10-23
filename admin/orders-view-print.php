<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Print Mauzo
                <a href="orders.php" class="btn btn-danger btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body" style="display: flex; flex-direction:column; justify-items:center; align-items: center;">

            <div id="myBillingArea" style="border: 1px solid black; width: 350px; height: fit-content;">
                <?php
                if (isset($_GET['track'])) {
                    $trackingNo = validate($_GET['track']);
                    if ($trackingNo == '') {
                ?>
                        <div class="text-center py-5">
                            <h5>Please provide Tracking Number</h5>
                            <div>
                                <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                            </div>
                        </div>
                    <?php
                    }

                    $orderQuery = "SELECT o.*, c.* FROM orders o, customers c 
                            WHERE c.id=o.customer_id AND tracking_no='$trackingNo' LIMIT 1";
                    $orderQueryRes = mysqli_query($conn, $orderQuery);

                    if (!$orderQueryRes) {
                        echo "<h5>Something Went Wrong</h5>";
                        return false;
                    }

                    if (mysqli_num_rows($orderQueryRes) > 0) {
                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                        // print_r($orderDataRow);
                    ?>
                        <div class="table-responsive mb-3">
                            <table style="width: 100%;">
                                <tbody style="display: flex; flex-direction:column; justify-items:center; align-items: center;">
                                    <tr>
                                        <td style="text-align: center;" colspan="2">
                                            <img src="assets/img/wk.jpeg" alt="" width="150px" height="150px">
                                            <h5 style="font-size: 20px; line-height: 20px; margin:2px; padding: 0;">Risiti</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: start;" colspan="2">
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>TIN:</strong>          152-581-947</pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Ofisini:</strong>      0788928335</pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Tarehe:</strong>       <?= date('d M Y', strtotime($orderDataRow['order_date'])); ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Risiti:</strong>       <?= $orderDataRow['invoice_no']; ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Amelipa:</strong>      <?= $orderDataRow['paid_amount'] ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Anadaiwa:</strong>     <?= $orderDataRow['due_amount'] ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Status:</strong>       <?= $orderDataRow['order_status']; ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Mteja:</strong>        <?= $orderDataRow['name'] ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Simu:</strong>         <?= $orderDataRow['phone'] ?></pre>
                                            <pre style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;"><strong>Anapokwenda:</strong>  <?= $orderDataRow['destination'] ?></pre>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo "<h5>No data found</h5>";
                        return false;
                    }

                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* 
                            FROM orders o, order_items oi, products p 
                            WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trackingNo' ";

                    $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);
                    if ($orderItemQueryRes) {
                        if (mysqli_num_rows($orderItemQueryRes) > 0) {
                        ?>
                            <div class="table-responsive text-center mb-3">
                                <table style="width: 100%; margin-bottom: 10px;">
                                    <tbody style="display: flex; flex-direction:column; justify-items:center; align-items: center;">
                                        <tr>
                                            <td colspan="2">
                                                <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Bidhaa</p>
                                            </td>
                                        </tr>
                                        <tr style="  display:flex; flex-wrap: wrap; padding: 0 45px">

                                            <?php
                                            $i = 1;
                                            $totalAmount = 0;
                                            foreach ($orderItemQueryRes as $key => $row) :

                                                $totalAmount += $row['orderItemQuantity'] * $row['orderItemPrice'];
                                            ?>

                                                <td>
                                                    <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">
                                                        <?= $row['name']; ?> (<?= $row['orderItemQuantity'] ?>),
                                                    </p>
                                                </td>

                                            <?php endforeach; ?>

                                        </tr>

                                        <tr class="pt-2" style="  display:flex; justify-content: space-between; padding: 0 45px">
                                            <td colspan="2" style="text-align: left; ">
                                                <p style="font-weight: bold;">Jumla: </p>
                                            </td>
                                            <td style="text-align: right; ">
                                                <p style="font-weight: bold;"><?= number_format($totalAmount + $orderDataRow['surplus_amount'], 2) ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Asante na karibu tena</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    <?php
                        } else {
                            echo "<h5>No data found</h5>";
                            return false;
                        }
                    } else {
                        echo "<h5>Something Went Wrong!</h5>";
                        return false;
                    }
                } else {
                    ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Number Parameter Found</h5>
                        <div>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
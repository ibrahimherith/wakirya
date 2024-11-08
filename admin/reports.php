<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Ripoti</h4>
                </div>
                <!-- Search Input -->
                <div class="col-md-4 offset-md-4">
                    <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Print</button>
                    <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF()">Download PDF</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="myBillingArea">

                <?php alertMessage(); ?>

                <?php

                $sql = "SELECT 
                    o.id AS order_id,
                    o.tracking_no,
                    o.invoice_no,
                    o.total_amount,
                    o.paid_amount,
                    o.due_amount,
                    o.loan_payment,
                    o.salary_payment,
                    o.other_payment,
                    o.order_date,
                    o.order_status,
                    c.name AS customer_name,
                    c.phone AS customer_phone
                    FROM orders o
                    JOIN customers c ON o.customer_id = c.id
                    ORDER BY o.order_date DESC";

                $orders = $conn->query($sql);

                if ($orders) {
                    if (mysqli_num_rows($orders) > 0) {
                        $amountTotal = 0;
                        $salesTotal = 0;
                        $loanTotal = 0;
                        $salaryTotal = 0;
                        $otherTotal = 0;
                ?>
                        <table class="table table-striped table-bordered align-items-center justify-content-center" id="orderTable">
                            <thead>
                                <tr>
                                    <th>Ankara</th>
                                    <th>Mauzo</th>
                                    <th>Mapato</th>
                                    <th>Mkopo</th>
                                    <th>Mshahara</th>
                                    <th>Mengineyo</th>
                                    <th>Tarehe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orders as $order) :
                                    $expenses = $order['loan_payment'] + $order['salary_payment'] + $order['other_payment'];
                                    $amountTotal += $order['total_amount'];
                                    $salesTotal += ($order['total_amount'] - $expenses);
                                    $loanTotal += $order['loan_payment'];
                                    $salaryTotal += $order['salary_payment'];
                                    $otherTotal += $order['other_payment'];
                                ?>
                                    <tr>
                                        <td class="sm-text"><?= $order['invoice_no'] ?></td>
                                        <td><?= number_format($order['total_amount'], 2); ?></td>
                                        <td><?= number_format($order['total_amount'] - $expenses, 2); ?></td>
                                        <td><?= number_format($order['loan_payment'], 2); ?></td>
                                        <td><?= number_format($order['salary_payment'], 2);  ?></td>
                                        <td><?= number_format($order['other_payment'], 2); ?></td>
                                        <td><?= date('d-m-Y', strtotime($order['order_date'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th>Jumla</th>
                                    <th><?= number_format($amountTotal, 2); ?></th>
                                    <th><?= number_format($salesTotal, 2); ?></th>
                                    <th><?= number_format($loanTotal, 2); ?></th>
                                    <th><?= number_format($salaryTotal, 2); ?></th>
                                    <th><?= number_format($otherTotal, 2); ?></th>
                                    <th></th>
                                </tr>
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
</div>

<?php include('includes/footer.php'); ?>

<script>
    function printMyBillingArea() {
        var divContents = document.getElementById("myBillingArea").innerHTML;
        var printWindow = window.open('', '', 'height=700,width=900');
        printWindow.document.write('<html><title>POS System in PHP</title>');
        printWindow.document.write('<body style="font-family: fangsong;">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    window.jsPDF = window.jspdf.jsPDF;
    var docPDF = new jsPDF();

    function downloadPDF() {
        var elementHTML = document.querySelector("#myBillingArea");
        var invoiceNo = "orders_report"; // Change this to a unique identifier if needed

        // Initialize jsPDF in landscape mode with A4 size and smaller font size
        var docPDF = new jsPDF({
            orientation: 'landscape',
            unit: 'pt',
            format: 'A4'
        });

        docPDF.setFontSize(10); // Reduce font size to fit more content

        docPDF.html(elementHTML, {
            callback: function(doc) {
                doc.save(invoiceNo + '.pdf');
            },
            x: 20, // Adjust margins
            y: 20,
            width: 770, // Wider width for landscape
            windowWidth: 1200 // Window width to accommodate more content
        });
    }
</script>
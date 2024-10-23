<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">

    <h3 class="mt-4">Dashboard</h3>
    <?php alertMessage(); ?>

    <div class="row mb-3">
        <div class="col-md-12 mb-0">
            <hr>
            <h5>Mauzo</h5>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card card-img-holder bg-primary text-white align-items-center justify-content-center">
                <div class="card-body">

                    <p></p>
                    <p></p>

                    <h3 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $todayDate = date('Y-m-d');

                        $todaySales = mysqli_query($conn, "SELECT SUM(paid_amount) AS sales_amount, SUM(surplus_amount) AS bonus_amount 
                        FROM orders WHERE order_date='$todayDate'");

                        $todayLoans = mysqli_query($conn, "SELECT SUM(paid_amount) AS loans_amount, SUM(surplus_amount) AS loan_bonus 
                        FROM loans WHERE order_date='$todayDate'");

                        $todayPreorders = mysqli_query($conn, "SELECT SUM(paid_amount) AS pre_amount, SUM(surplus_amount) AS pre_bonus 
                        FROM preorders WHERE order_date='$todayDate'");

                        if ($todaySales || $todayLoans || $todayPreorders) {
                            $sales_result = mysqli_fetch_assoc($todaySales);
                            $sales_amount = $sales_result['sales_amount'] !== null ? $sales_result['sales_amount'] : 0;
                            $bonus_amount = $sales_result['bonus_amount'] !== null ? $sales_result['bonus_amount'] : 0;

                            $loans_result = mysqli_fetch_assoc($todayLoans);
                            $loans_amount = $loans_result['loans_amount'] !== null ? $loans_result['loans_amount'] : 0;
                            $loan_bonus = $loans_result['loan_bonus'] !== null ? $loans_result['loan_bonus'] : 0;

                            $preorders_result = mysqli_fetch_assoc($todayPreorders);
                            $pre_amount = $preorders_result['pre_amount'] !== null ? $preorders_result['pre_amount'] : 0;
                            $pre_bonus = $preorders_result['pre_bonus'] !== null ? $preorders_result['pre_bonus'] : 0;

                            $final_result = $sales_amount + $bonus_amount + $loans_amount + $loan_bonus + $pre_amount + $pre_bonus;

                            echo number_format($final_result) . "/=";
                        } else {
                            echo 'Something Went Wrong!';
                        }
                        ?>

                    </h3>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Siku
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center ">
                <div class="card-body  ">
                    <p></p>
                    <p></p>

                    <h3 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $todayDate = date('Y-m-d');

                        $weekSales = mysqli_query($conn, "SELECT SUM(paid_amount) AS sales_amount, SUM(surplus_amount) AS bonus_amount 
                            FROM orders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $weekLoans = mysqli_query($conn, "SELECT SUM(paid_amount) AS loans_amount, SUM(surplus_amount) AS loan_bonus 
                            FROM loans WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $weekPre = mysqli_query($conn, "SELECT SUM(paid_amount) AS pre_amount, SUM(surplus_amount) AS pre_bonus 
                            FROM preorders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        if ($weekSales && $weekLoans && $weekPre) {
                            $sales_result = mysqli_fetch_assoc($weekSales);
                            $sales_amount = $sales_result['sales_amount'] !== null ? $sales_result['sales_amount'] : 0;
                            $bonus_amount = $sales_result['bonus_amount'] !== null ? $sales_result['bonus_amount'] : 0;

                            $loans_result = mysqli_fetch_assoc($weekLoans);
                            $loans_amount = $loans_result['loans_amount'] !== null ? $loans_result['loans_amount'] : 0;
                            $loan_bonus = $loans_result['loan_bonus'] !== null ? $loans_result['loan_bonus'] : 0;

                            $preorders_result = mysqli_fetch_assoc($weekPre);
                            $pre_amount = $preorders_result['pre_amount'] !== null ? $preorders_result['pre_amount'] : 0;
                            $pre_bonus = $preorders_result['pre_bonus'] !== null ? $preorders_result['pre_bonus'] : 0;

                            $final_result = $sales_amount + $bonus_amount + $loans_amount + $loan_bonus + $pre_amount + $pre_bonus;

                            echo number_format($final_result) . "/=";
                        } else {
                            echo 'Something Went Wrong!';
                        }
                        ?>
                    </h3>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Wiki
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include('includes/footer.php'); ?>
<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">

    <?php alertMessage(); ?>

    <div class="row mb-3">
        <div class="col-md-12 mb-0">
            <hr>
            <h5>Mapato</h5>
        </div>

        <div class="col-xl-4 mb-3 col-md-6">
            <div class="card card-img-holder bg-primary text-white align-items-center justify-content-center">
                <div class="card-body">
                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $todayDate = date('Y-m-d');

                        $todaySales = mysqli_query($conn, "SELECT SUM(paid_amount) AS sales_amount, SUM(surplus_amount) AS bonus_amount 
                        FROM orders WHERE order_date='$todayDate'");

                        $todayLoans = mysqli_query($conn, "SELECT SUM(paid_amount) AS loans_amount, SUM(surplus_amount) AS loan_bonus 
                        FROM loans WHERE order_date='$todayDate'");

                        $todayPreorders = mysqli_query($conn, "SELECT SUM(paid_amount) AS pre_amount, SUM(surplus_amount) AS pre_bonus 
                        FROM preorders WHERE order_date='$todayDate'");

                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM orders WHERE order_date='$todayDate'");
                        $orders_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM orders WHERE order_date='$todayDate'");
                        $orders_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM orders WHERE order_date='$todayDate'");

                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM loans WHERE order_date='$todayDate'");
                        $loans_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM loans WHERE order_date='$todayDate'");
                        $loans_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM loans WHERE order_date='$todayDate'");

                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM preorders WHERE order_date='$todayDate'");
                        $pre_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM preorders WHERE order_date='$todayDate'");
                        $pre_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM preorders WHERE order_date='$todayDate'");

                        // orders
                        if ($orders_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($orders_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($orders_SalaryPayment);
                            $orders_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($orders_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($orders_OtherPayment);
                            $orders_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //loans
                        if ($loans_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($loans_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($loans_SalaryPayment);
                            $loans_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($loans_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($loans_OtherPayment);
                            $loans_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //preorders
                        if ($pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($pre_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($pre_SalaryPayment);
                            $pre_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($pre_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($pre_OtherPayment);
                            $pre_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        $orders_expenses = $orders_loan + $orders_salary + $orders_other;
                        $loans_expenses = $loans_loan + $loans_salary + $loans_other;
                        $pre_expenses = $pre_loan + $pre_salary + $pre_other;

                        if ($todaySales || $todayLoans || $todayPreorders) {
                            $sales_result = mysqli_fetch_assoc($todaySales);
                            $sales_amount = $sales_result['sales_amount'] !== null ? $sales_result['sales_amount'] : 0;
                            $bonus_amount = $sales_result['bonus_amount'] !== null ? $sales_result['bonus_amount'] : 0;
                            $final_sales = $sales_amount + $bonus_amount;
                            $final_sales = $final_sales - $orders_expenses;

                            $loans_result = mysqli_fetch_assoc($todayLoans);
                            $loans_amount = $loans_result['loans_amount'] !== null ? $loans_result['loans_amount'] : 0;
                            $loan_bonus = $loans_result['loan_bonus'] !== null ? $loans_result['loan_bonus'] : 0;
                            $final_loans = $loans_amount + $loan_bonus;
                            $final_loans = $final_loans - $loans_expenses;

                            $preorders_result = mysqli_fetch_assoc($todayPreorders);
                            $pre_amount = $preorders_result['pre_amount'] !== null ? $preorders_result['pre_amount'] : 0;
                            $pre_bonus = $preorders_result['pre_bonus'] !== null ? $preorders_result['pre_bonus'] : 0;
                            $final_pre = $pre_amount + $pre_bonus;
                            $final_pre = $final_pre - $pre_expenses;

                            $final_result = $final_sales + $final_loans + $final_pre;

                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }
                        ?>

                    </h5>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Siku
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center ">
                <div class="card-body  ">
                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $todayDate = date('Y-m-d');

                        $weekSales = mysqli_query($conn, "SELECT SUM(paid_amount) AS sales_amount, SUM(surplus_amount) AS bonus_amount 
                            FROM orders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $weekLoans = mysqli_query($conn, "SELECT SUM(paid_amount) AS loans_amount, SUM(surplus_amount) AS loan_bonus 
                            FROM loans WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $weekPre = mysqli_query($conn, "SELECT SUM(paid_amount) AS pre_amount, SUM(surplus_amount) AS pre_bonus 
                            FROM preorders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM orders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $orders_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM orders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $orders_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM orders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM loans WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $loans_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM loans WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $loans_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM loans WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM preorders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $pre_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM preorders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");
                        $pre_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM preorders WHERE WEEK(order_date, 1) = WEEK('$todayDate', 1) AND YEAR(order_date) = YEAR('$todayDate')");

                        // orders
                        if ($orders_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($orders_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($orders_SalaryPayment);
                            $orders_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($orders_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($orders_OtherPayment);
                            $orders_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //loans
                        if ($loans_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($loans_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($loans_SalaryPayment);
                            $loans_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($loans_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($loans_OtherPayment);
                            $loans_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //preorders
                        if ($pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($pre_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($pre_SalaryPayment);
                            $pre_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($pre_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($pre_OtherPayment);
                            $pre_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        $orders_expenses = $orders_loan + $orders_salary + $orders_other;
                        $loans_expenses = $loans_loan + $loans_salary + $loans_other;
                        $pre_expenses = $pre_loan + $pre_salary + $pre_other;

                        if ($weekSales || $weekLoans || $weekPre) {
                            $sales_result = mysqli_fetch_assoc($weekSales);
                            $sales_amount = $sales_result['sales_amount'] !== null ? $sales_result['sales_amount'] : 0;
                            $bonus_amount = $sales_result['bonus_amount'] !== null ? $sales_result['bonus_amount'] : 0;
                            $final_sales = $sales_amount + $bonus_amount;
                            $final_sales -= $orders_expenses;

                            $loans_result = mysqli_fetch_assoc($weekLoans);
                            $loans_amount = $loans_result['loans_amount'] !== null ? $loans_result['loans_amount'] : 0;
                            $loan_bonus = $loans_result['loan_bonus'] !== null ? $loans_result['loan_bonus'] : 0;
                            $final_loans = $loans_amount + $loan_bonus;
                            $final_loans -= $loans_expenses;

                            $preorders_result = mysqli_fetch_assoc($weekPre);
                            $pre_amount = $preorders_result['pre_amount'] !== null ? $preorders_result['pre_amount'] : 0;
                            $pre_bonus = $preorders_result['pre_bonus'] !== null ? $preorders_result['pre_bonus'] : 0;
                            $final_pre = $pre_amount + $pre_bonus;
                            $final_pre -= $pre_expenses;

                            $final_result = $final_sales + $final_loans + $final_pre;

                            // $final_result = $final_result - $final_expenses;

                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }
                        ?>

                    </h5>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Wiki
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center">
                <div class="card-body  ">
                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $totalSales = mysqli_query($conn, "SELECT SUM(paid_amount) AS sales_amount, SUM(surplus_amount) AS bonus_amount 
                                                             FROM orders");

                        $totalLoans = mysqli_query($conn, "SELECT SUM(paid_amount) AS loans_amount, SUM(surplus_amount) AS loan_bonus 
                            FROM loans");

                        $totalPre = mysqli_query($conn, "SELECT SUM(paid_amount) AS pre_amount, SUM(surplus_amount) AS pre_bonus 
                            FROM preorders");

                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM orders");
                        $orders_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM orders");
                        $orders_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM orders");

                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM loans");
                        $loans_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM loans");
                        $loans_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM loans");

                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_loan FROM preorders");
                        $pre_SalaryPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_salary FROM preorders");
                        $pre_OtherPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_other FROM preorders");

                        // orders
                        if ($orders_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($orders_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($orders_SalaryPayment);
                            $orders_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($orders_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($orders_OtherPayment);
                            $orders_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //loans
                        if ($loans_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($loans_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($loans_SalaryPayment);
                            $loans_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($loans_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($loans_OtherPayment);
                            $loans_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        //preorders
                        if ($pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_loan = $loan_payment_result['payment_loan'] !== null ? $loan_payment_result['payment_loan'] : 0;
                        }

                        if ($pre_SalaryPayment) {
                            $salary_payment_result = mysqli_fetch_assoc($pre_SalaryPayment);
                            $pre_salary = $salary_payment_result['payment_salary'] !== null ? $salary_payment_result['payment_salary'] : 0;
                        }

                        if ($pre_OtherPayment) {
                            $other_payment_result = mysqli_fetch_assoc($pre_OtherPayment);
                            $pre_other = $other_payment_result['payment_other'] !== null ? $other_payment_result['payment_other'] : 0;
                        }

                        $orders_expenses = $orders_loan + $orders_salary + $orders_other;
                        $loans_expenses = $loans_loan + $loans_salary + $loans_other;
                        $pre_expenses = $pre_loan + $pre_salary + $pre_other;

                        if ($totalSales || $totalLoans || $totalPre) {
                            $sales_result = mysqli_fetch_assoc($totalSales);
                            $sales_amount = $sales_result['sales_amount'] !== null ? $sales_result['sales_amount'] : 0;
                            $bonus_amount = $sales_result['bonus_amount'] !== null ? $sales_result['bonus_amount'] : 0;
                            $final_sales = $sales_amount + $bonus_amount;
                            $final_sales -= $orders_expenses;

                            $loans_result = mysqli_fetch_assoc($totalLoans);
                            $loans_amount = $loans_result['loans_amount'] !== null ? $loans_result['loans_amount'] : 0;
                            $loan_bonus = $loans_result['loan_bonus'] !== null ? $loans_result['loan_bonus'] : 0;
                            $final_loans = $loans_amount + $loan_bonus;
                            $final_loans -= $loans_expenses;

                            $preorders_result = mysqli_fetch_assoc($totalPre);
                            $pre_amount = $preorders_result['pre_amount'] !== null ? $preorders_result['pre_amount'] : 0;
                            $pre_bonus = $preorders_result['pre_bonus'] !== null ? $preorders_result['pre_bonus'] : 0;
                            $final_pre = $pre_amount + $pre_bonus;
                            $final_pre -= $pre_expenses;

                            $final_result = $final_sales + $final_loans + $final_pre;

                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }

                        ?>
                    </h5>

                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Jumla
                    </p>
                </div>
            </div>
        </div>


        <!-- he -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center">
                <div class="card-body">

                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_amount FROM orders");
                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_amount FROM loans");
                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(loan_payment) AS payment_amount FROM preorders");

                        if ($orders_LoanPayment || $loans_LoanPayment || $pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $final_result = $orders_amount + $loans_amount + $pre_amount;
                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }

                        ?>
                    </h5>

                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Malipo mkopo
                    </p>
                </div>
            </div>
        </div>
        <!-- he -->

        <!-- he -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center">
                <div class="card-body  ">
                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_amount FROM orders");
                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_amount FROM loans");
                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(salary_payment) AS payment_amount FROM preorders");

                        if ($orders_LoanPayment || $loans_LoanPayment || $pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $final_result = $orders_amount + $loans_amount + $pre_amount;
                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }

                        ?>
                    </h5>

                    <p class="card-title  font-weight-bold text-white text-uppercase mb-1">
                        Malipo mshahara
                    </p>
                </div>
            </div>
        </div>
        <!-- he -->

        <!-- he -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white align-items-center justify-content-center">
                <div class="card-body  ">
                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $orders_LoanPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_amount FROM orders");
                        $loans_LoanPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_amount FROM loans");
                        $pre_LoanPayment = mysqli_query($conn, "SELECT SUM(other_payment) AS payment_amount FROM preorders");

                        if ($orders_LoanPayment || $loans_LoanPayment || $pre_LoanPayment) {
                            $loan_payment_result = mysqli_fetch_assoc($orders_LoanPayment);
                            $orders_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($loans_LoanPayment);
                            $loans_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $loan_payment_result = mysqli_fetch_assoc($pre_LoanPayment);
                            $pre_amount = $loan_payment_result['payment_amount'] !== null ? $loan_payment_result['payment_amount'] : 0;

                            $final_result = $orders_amount + $loans_amount + $pre_amount;
                            echo number_format($final_result) . " <span class='small'>TSH</span>";
                        } else {
                            echo 'Something Went Wrong!';
                        }
                        ?>
                    </h5>

                    <p class="card-title  font-weight-bold text-white text-uppercase mb-1">
                        Malipo mengineyo
                    </p>
                </div>
            </div>
        </div>
        <!-- he -->

    </div>

    <div class="row mb-3">
        <div class="col-md-12 mb-0">
            <hr>
            <h5>Mauzo/Mikopo/Agizo</h5>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white align-items-center justify-content-center">
                <div class="card-body ">

                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        $todayDate = date('Y-m-d');

                        $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date='$todayDate'");
                        $todayLoans = mysqli_query($conn, "SELECT * FROM loans WHERE order_date='$todayDate'");
                        $todayPreorders = mysqli_query($conn, "SELECT * FROM preorders WHERE order_date='$todayDate'");

                        if ((mysqli_num_rows($todayOrders) > 0) || (mysqli_num_rows($todayLoans) > 0) || (mysqli_num_rows($todayPreorders) > 0)) {
                            $totalCountOrders = mysqli_num_rows($todayOrders);
                            $totalCountLoans = mysqli_num_rows($todayLoans);
                            $totalCountPreorders = mysqli_num_rows($todayPreorders);

                            echo $totalCountOrders + $totalCountLoans + $totalCountPreorders;
                        } else {
                            echo "0";
                        }
                        ?>

                    </h5>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Leo
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white align-items-center justify-content-center ">
                <!-- <img class="card-img" src="assets/img/circle.png" alt="circle"> -->
                <div class="card-body ">


                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?php
                        function getCountHapa($tableName)
                        {
                            global $conn;
                            $query = "SELECT COUNT(*) as total FROM $tableName";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            return $row['total'];
                        }


                        $orders = getCountHapa('orders');
                        $loans = getCountHapa('loans');
                        $preorders = getCountHapa('preorders');

                        $total = $orders + $loans + $preorders;

                        echo $total;
                        ?>

                    </h5>

                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Jumla
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Others -->
    <div class="row">
        <div class="col-md-12 mb-0">
            <hr>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card bg-secondary text-white align-items-center justify-content-center">
                <!-- <img class="card-img" src="assets/img/circle.png" alt="circle"> -->
                <div class="card-body ">


                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?= getCount('products'); ?>
                    </h5>
                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Bidhaa
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-secondary text-white align-items-center justify-content-center">
                <!-- <img class="card-img" src="assets/img/circle.png" alt="circle"> -->
                <div class="card-body ">

                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?= getCount('customers'); ?>
                    </h5>

                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Wateja
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-secondary text-white align-items-center justify-content-center">
                <!-- <img class="card-img" src="assets/img/circle.png" alt="circle"> -->
                <div class="card-body ">


                    <h5 class="card-text mb-0 font-weight-bold text-gray-800">
                        <?= getCount('admins'); ?>
                    </h5>

                    <p class="card-title font-weight-bold text-white text-uppercase mb-1">
                        Wafanyakazi
                    </p>
                </div>
            </div>
        </div>


        <!-- <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Products (Bidhaa)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= getCount('products'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Customers (Wateja)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= getCount('customers'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Staff (Wafanyakazi)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= getCount('admins'); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


    </div>


</div>

<?php include('includes/footer.php'); ?>
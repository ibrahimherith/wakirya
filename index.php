<?php require 'config/function.php'; ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wakirya</title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- end fonts -->

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body style="font-family: 'Poppins', sans-serif; font-size: 15px;">

    <div class="py-5">
        <div class="container">
            <div class="row d-flex flex-column align-items-center">
                <div class="col-md-6 shadow-lg rounded-4">

                    <?php alertMessage(); ?>

                    <div class="w-100 text-center">
                        <img src="assets/images/wk.jpeg" alt="wakirya logo" width="150px" height="150px">
                    </div>
                    <div class="px-5 pb-5">
                        <h4 class="text-dark mb-3">Sign in</h4>
                        <form action="login.php" method="POST">

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required />
                            </div>
                            <div class="my-3">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">
                                    Sign In
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
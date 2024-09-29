<?php include('includes/header.php'); ?>

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
                    <form action="login-code.php" method="POST">

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

<?php include('includes/footer.php'); ?>
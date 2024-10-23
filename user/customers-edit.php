<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Rekebisha Taarifa za Mteja
                <a href="customers.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST">

                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>' . $paramValue . '</h5>';
                    return false;
                }

                $customer = getById('customers', $paramValue);
                if ($customer['status'] == 200) {
                ?>

                    <input type="hidden" name="customerId" value="<?= $customer['data']['id']; ?>" />

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Jina *</label>
                            <input type="text" name="name" required value="<?= $customer['data']['name']; ?>" class="form-control" />
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Simu Na. *</label>
                            <input type="number" name="phone" value="<?= $customer['data']['phone']; ?>" class="form-control" />
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <br />
                            <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<h5>' . $customer['message'] . '</h5>';
                    return false;
                }
                ?>


            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
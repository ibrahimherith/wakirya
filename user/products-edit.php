<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Rekebisha Taarifa za Bidhaa
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">


                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }

                $product = getById('products', $paramValue);
                if ($product) {
                    if ($product['status'] == 200) {
                ?>

                        <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>" />

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Jina *</label>
                                <input type="text" name="name" required value="<?= $product['data']['name']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Batch Na. *</label>
                                <input type="text" name="batch" required value="<?= $product['data']['batch']; ?>" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Idadi *</label>
                                <input type="text" name="quantity" required value="<?= $product['data']['quantity']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Kipimo</label>
                                <input type="text" name="measure" value="<?= $product['data']['measure']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bei ya Kununua *</label>
                                <input type="text" name="buy_price" required value="<?= $product['data']['buy_price']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bei ya Kuuza *</label>
                                <input type="text" name="sell_price" required value="<?= $product['data']['sell_price']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <br />
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                    }
                } else {
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                ?>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
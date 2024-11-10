<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Rekebisha taarifa za bidhaa
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
                        $productBatch = $product['data']['batch'];
                ?>

                        <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>" />

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Jina *</label>
                                <input type="text" name="name" required value="<?= $product['data']['name']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Batch Na. *</label>
                                <input type="text" name="batch" required value="<?= $product['data']['batch']; ?>" class="form-control" readonly />
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
                                <label for="">Bei ya kununua *</label>
                                <input type="text" name="buy_price" required value="<?= $product['data']['buy_price']; ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bei ya kuuza *</label>
                                <input type="text" name="sell_price" required value="<?= $product['data']['sell_price']; ?>" class="form-control" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expense-1">Makato ya matumizi</label>
                                <select class="form-control" name="expense-1" id="expense-1">
                                    <option value="">-- Chagua --</option>
                                    <option value="mkopo" <?= ($product['data']['expense_1'] == 'mkopo') ? 'selected' : ''; ?>>Mkopo</option>
                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="">Makato (%)</label>
                                <input type="number" name="percent-1" value="<?= $product['data']['percent_1']; ?>" class="form-control" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expense-2">Makato ya matumizi (2)</label>
                                <select class="form-control" name="expense-2" id="expense-2">
                                    <option value="">-- Chagua --</option>
                                    <option value="mshahara" <?= ($product['data']['expense_2'] == 'mshahara') ? 'selected' : ''; ?>>Mshahara</option>
                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="">Makato (%)</label>
                                <input type="number" name="percent-2" value="<?= $product['data']['percent_2']; ?>" class="form-control" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expense-3">Makato ya matumizi (3)</label>
                                <select class="form-control" name="expense-3" id="expense-3">
                                    <option value="">-- Chagua --</option>
                                    <option value="mengineyo" <?= ($product['data']['expense_2'] == 'mengineyo') ? 'selected' : ''; ?>>Mengineyo</option>
                                </select>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="">Makato (%)</label>
                                <input type="number" name="percent-3" value="<?= $product['data']['percent_3']; ?>" class="form-control" />
                            </div>

                            <div class="col-md-12 mb-3">
                                <br />
                                <button type="submit" name="updateProduct" class="btn btn-primary">Rekebisha</button>
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
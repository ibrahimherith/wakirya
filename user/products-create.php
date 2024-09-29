<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Ongeza Bidhaa
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Jina *</label>
                        <input type="text" name="name" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Batch Na. *</label>
                        <input type="text" name="batch" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Idadi *</label>
                        <input type="text" name="quantity" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Kipimo</label>
                        <input type="text" name="measure" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Bei ya Kununua *</label>
                        <input type="text" name="buy_price" required class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Bei ya Kuuza *</label>
                        <input type="text" name="sell_price" required class="form-control" />
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
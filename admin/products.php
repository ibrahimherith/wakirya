<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Bidhaa
                <a href="products-create.php" class="btn btn-primary float-end">Ongeza Bidhaa</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php

            $query = "SELECT * FROM products";
            $products = mysqli_query($conn, $query);

            if (!$products) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            ?>

            <?php if (mysqli_num_rows($products) > 0) { ?>
                <div class="table-responsive">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Na.</th>
                                <th>Jina</th>
                                <th>Batch Na.</th>
                                <th>Idadi</th>
                                <th>Kipimo</th>
                                <th>Bei ya Kununua</th>
                                <th>Bei ya Kuuzia</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1; // Start numbering from the current page's first product
                            foreach ($products as $item) : ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['batch'] ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= $item['measure'] ?></td>
                                    <td><?= $item['buy_price'] ?></td>
                                    <td><?= $item['sell_price'] ?></td>
                                    <td>
                                        <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="products-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php } else { ?>
                <h4 class="mb-0">No Record found</h4>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
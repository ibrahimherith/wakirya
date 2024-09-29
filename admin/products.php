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

            <!-- Pagination logic -->
            <?php
            $limit = 10; // Set the number of products per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Count total products
            $countQuery = "SELECT COUNT(*) as total FROM products";
            $countResult = mysqli_query($conn, $countQuery);
            $productCount = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($productCount / $limit);

            // Fetch products with limit
            $query = "SELECT * FROM products LIMIT $start, $limit";
            $products = mysqli_query($conn, $query);

            if (!$products) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            ?>

            <!-- Search input -->
            <div class="mb-3">
                <input type="text" id="productSearch" class="form-control" placeholder="Tafuta bidhaa...">
            </div>

            <?php if (mysqli_num_rows($products) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="productTable">
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
                            $count = $start + 1; // Start numbering from the current page's first product
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

                <!-- Pagination Links -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

            <?php } else { ?>
                <h4 class="mb-0">No Record found</h4>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- Add jQuery to handle search functionality -->
<script>
    $(document).ready(function() {
        $("#productSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#productTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
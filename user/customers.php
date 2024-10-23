<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Wateja
                <a href="customers-create.php" class="btn btn-primary float-end">Ongeza Mteja</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <!-- Pagination logic -->
            <?php
            $limit = 10; // Set the number of customers per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Count total customers
            $countQuery = "SELECT COUNT(*) as total FROM customers";
            $countResult = mysqli_query($conn, $countQuery);
            $customerCount = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($customerCount / $limit);

            // Fetch customers with limit
            $query = "SELECT * FROM customers LIMIT $start, $limit";
            $customers = mysqli_query($conn, $query);

            if (!$customers) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            ?>

            <!-- Search input -->
            <div class="mb-3">
                <input type="text" id="customerSearch" class="form-control" placeholder="Tafuta mteja...">
            </div>

            <?php if (mysqli_num_rows($customers) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="customerTable">
                        <thead>
                            <tr>
                                <th>Na.</th>
                                <th>Jina</th>
                                <th>Simu Na.</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = $start + 1; // Start numbering from the current page's first customer
                            foreach ($customers as $item) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['phone'] ?></td>
                                    <td>
                                        <a href="customers-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="customers-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
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
        $("#customerSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#customerTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
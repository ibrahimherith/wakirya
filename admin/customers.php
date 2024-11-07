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

            $query = "SELECT * FROM customers";
            $customers = mysqli_query($conn, $query);

            if (!$customers) {
                echo '<h4>Something Went Wrong!</h4>';
                return false;
            }
            ?>

            <?php if (mysqli_num_rows($customers) > 0) { ?>
                <div class="table-responsive">
                    <table id="datatablesSimple">
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
                            $i = 1; // Start numbering from the current page's first customer
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

            <?php } else { ?>
                <h4 class="mb-0">No Record found</h4>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
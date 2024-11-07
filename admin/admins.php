<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Wafanyakazi
                <a href="admins-create.php" class="btn btn-primary float-end">Ongeza Mfanyakazi</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            $admins = getAll('admins');
            if (!$admins) {
                echo '<h4>Something Went Wrong!</h4>';
                exit;
            }

            if (mysqli_num_rows($admins) > 0) {
            ?>
                <table id="datatablesSimple" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Na.</th>
                            <th>Jina</th>
                            <th>Anuani</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($admins as $admin) :
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $admin['name'] ?></td>
                                <td><?= $admin['email'] ?></td>
                                <td><?= $admin['role'] ?></td>
                                <td>
                                    <?php
                                    if ($admin['is_ban'] == 1) {
                                        echo '<span class="badge bg-danger">Banned</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">Active</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="admins-edit.php?id=<?= $admin['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="admins-delete.php?id=<?= $admin['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo '<h4 class="mb-0">No Record found</h4>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
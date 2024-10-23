<?php include('includes/header.php'); ?>

<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sajili Mteja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Jina la Mteja</label>
                    <input type="text" class="form-control" id="c_name" />
                </div>
                <div class="mb-3">
                    <label>Namba ya Simu</label>
                    <input type="text" class="form-control" id="c_phone" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary saveCustomer">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Mauzo
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <form action="orders-code.php" method="POST">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="">Bidhaa</label>
                        <select name="product_id" class="form-select mySelect2">
                            <option value=""> -- Chagua -- </option>
                            <?php
                            $products = getAll('products');
                            if ($products) {
                                if (mysqli_num_rows($products) > 0) {
                                    foreach ($products as $prodItem) {
                            ?>
                                        <option value="<?= $prodItem['id']; ?>"><?= $prodItem['name']; ?></option>
                            <?php
                                    }
                                } else {
                                    echo '<option value="">No product found</option>';
                                }
                            } else {
                                echo '<option value="">Something Went Wrong</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Idadi</label>
                        <input type="number" name="quantity" value="1" class="form-control" />
                    </div>
                    <div class="col-md-3 mb-3 text-start">
                        <br />
                        <button type="submit" name="addItem" class="btn btn-primary">Chagua Bidhaa</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Bidhaa</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
            if (isset($_SESSION['productItems']) && !empty($_SESSION['productItems'])) {
                $sessionProducts = $_SESSION['productItems'];

            ?>
                <div class="table-responsive mb-3" id="productContent">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Na.</th>
                                <th>Jina</th>
                                <th>Bei</th>
                                <th>Kiasi</th>
                                <th>Kipimo</th>
                                <th>Jumla</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $totalAmount = 0;
                            foreach ($sessionProducts as $key => $item) :
                                $totalAmount += $item['sell_price'] * $item['quantity']
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $item['name']; ?></td>
                                    <td><?= $item['sell_price']; ?></td>

                                    <td>
                                        <div class="input-group qtyBox">
                                            <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId" />
                                            <button class="input-group-text decrement">-</button>
                                            <input type="text" value="<?= $item['quantity']; ?>" class="qty quantityInput" />
                                            <button class="input-group-text increment">+</button>
                                        </div>
                                    </td>

                                    <td><?= $item['measure']; ?></td>
                                    <td><?= number_format($item['sell_price'] * $item['quantity'], 0); ?></td>
                                    <td>
                                        <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">
                                            Ondoa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <p>
                        <strong>Jumla ya Gharama: <?= number_format($totalAmount, 0); ?></strong>
                    </p>
                </div>

                <div class="mt-2">
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kiasi alicholipa</label>
                            <input type="number" id="amount_paid" class="form-control" value="" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jina</label>
                            <input type="text" id="jina" class="form-control" value="" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Anapokwenda</label>
                            <input type="text" id="destination" class="form-control" value="" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Maoni</label>
                            <textarea id="comment" class="form-control" rows="1"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <br />
                            <button type="button" class="btn btn-success w-100 proceedToPlace">Fanya Mauzo</button>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                if (isset($_SESSION['productItems']) && empty($_SESSION['productItems'])) {
                    unset($_SESSION['productItemIds']);
                    unset($_SESSION['productItems']);
                }
                echo '<h5>Hakuna bidhaa iliyo chaguliwa</h5>';
            }
            ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>
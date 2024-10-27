<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>

<div id="layoutSidenav_nav" class="sidebar-css">
    <nav class="sb-sidenav accordion sb-sidenav-light shadow-lg" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link <?= $page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Dashboard
                </a>

                <!-- Orders -->
                <div class="w-75 mx-auto">
                    <hr>
                </div>
                <a class="nav-link <?= $page == 'order-create.php' ? 'active' : ''; ?>"
                    href="order-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-cart-shopping"></i></div>
                    Mauzo
                </a>
                <a class="nav-link <?= $page == 'orders.php' ? 'active' : ''; ?>" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Angalia Mauzo
                </a>


                <div class="w-75 mx-auto">
                    <hr>
                </div>
                <a class="nav-link <?= $page == 'loan-create.php' ? 'active' : ''; ?>"
                    href="loan-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bag-shopping"></i></div>
                    Mkopo
                </a>
                <a class="nav-link <?= $page == 'loans.php' ? 'active' : ''; ?>" href="loans.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Angalia Mikopo
                </a>


                <div class="w-75 mx-auto">
                    <hr>
                </div>
                <a class="nav-link <?= $page == 'preorder-create.php' ? 'active' : ''; ?>"
                    href="preorder-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                    Oda
                </a>
                <a class="nav-link <?= $page == 'preorders.php' ? 'active' : ''; ?>" href="preorders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Angalia Oda
                </a>


                <!-- PRODUCTS -->
                <div class="sb-sidenav-menu-heading">STOCK</div>
                <a class="nav-link <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'collapse active' : 'collapsed'; ?>" href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                    Bidhaa
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'show' : ''; ?>" id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'products-create.php' ? 'active' : ''; ?>" href="products-create.php">Ongeza Bidhaa</a>
                        <a class="nav-link <?= $page == 'products.php' ? 'active' : ''; ?>" href="products.php">Angalia Bidhaa</a>
                    </nav>
                </div>


                <!-- CUSTOMERS AND STAFF -->
                <div class="sb-sidenav-menu-heading">Manage Users</div>
                <a class="nav-link <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'collapse active' : 'collapsed'; ?>" href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseCustomer"
                    aria-expanded="false" aria-controls="collapseCustomer">

                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Wateja
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'show' : ''; ?>" id="collapseCustomer" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'customers-create.php' ? 'active' : ''; ?>" href="customers-create.php">Ongeza Mteja</a>
                        <a class="nav-link <?= $page == 'customers.php' ? 'active' : ''; ?>" href="customers.php">Angalia Wateja</a>
                    </nav>
                </div>

                <a class="nav-link <?= ($page == 'admins-create.php') || ($page == 'admins.php') ? 'collapse active' : 'collapsed'; ?>" href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseAdmins"
                    aria-expanded="false" aria-controls="collapseAdmins">

                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Wafanyakazi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'admins-create.php') || ($page == 'admins.php') ? 'show' : ''; ?>" id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'admins-create.php' ? 'active' : ''; ?>" href="admins-create.php">Ongeza Mfanyakazi</a>
                        <a class="nav-link <?= $page == 'admins.php' ? 'active' : ''; ?>" href="admins.php">Angalia Wafanyakazi</a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading ,mb-0">
                    <hr>
                </div>

            </div>
        </div>
    </nav>
</div>
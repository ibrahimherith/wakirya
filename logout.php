<?php

require 'config/function.php';

if (isset($_SESSION['loggedIn'])) {

    logoutSession();
    redirect('index.php', 'Logged Out Successfully.');
}

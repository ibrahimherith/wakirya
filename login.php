<?php

require 'config/function.php';

if (isset($_POST['loginBtn'])) {
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if ($email != '' && $password != '') {
        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {

            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_assoc($result);
                $userEmail = $row['email'];

                $hasedPassword = $row['password'];

                if (!password_verify($password, $hasedPassword)) {
                    redirect('index.php', 'Invalid Email or Password');
                }

                if ($row['is_ban'] == 1) {
                    redirect('index.php', 'You accout has been banned. Contact your Admin.');
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role' => $row['role'],
                ];

                // Use role instead later
                if ($row['role'] == "admin") {
                    redirect('admin/index.php', 'Logged In Successfully');
                } else {
                    redirect('user/index.php', 'Logged In Successfully');
                }
            } else {
                redirect('index.php', 'Invalid Email or Password');
            }
        } else {
            redirect('index.php', 'Something Went Wrong!');
        }
    } else {
        redirect('index.php', 'All fields are mandetory!');
    }
}

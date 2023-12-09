<?php
session_start();
$errors = ""; // Initialize $errors variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {   //kiểm tra xem form có gửi = post ko
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == '123456') {
        //Tao 1 session luu thong tin nguoi dung
        $_SESSION['username'] = $username;
        header('location: index.php');
        die;
    } else {
        $errors = "Tên tài khoản hoặc mật khẩu không đúng";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div style="color: red">
        <?= $errors ?>
    </div>
    <form action="" method="post">
        Username: <input type="text" name="username" id="">
        <br><br>
        Password : <input type="password" name="password" id="">
        <br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>

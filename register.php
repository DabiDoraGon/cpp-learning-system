<?php
include("includes/db.php");

$msg = "";

if($_POST){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == "" || $password == ""){
        $msg = "Vui lòng nhập đầy đủ";
    } else {

        $check = $conn->query("SELECT * FROM users WHERE username='$username'");

        if($check->num_rows > 0){
            $msg = "Tên đăng nhập đã tồn tại";
        } else {

            $conn->query("
            INSERT INTO users(username,password,role,status)
            VALUES('$username','$password','student','pending')
            ");

            $msg = "Đăng ký thành công! Chờ admin duyệt";
        }
    }
}
?>

<form method="POST">
<input name="username" placeholder="Username">
<input name="password" type="password" placeholder="Password">
<button>Đăng ký</button>
</form>

<p><?= $msg ?></p>
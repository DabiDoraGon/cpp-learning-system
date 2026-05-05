<?php
include("includes/db.php");

$msg = "";

if($_POST){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == "" || $password == ""){
        $msg = "<div class='alert alert-danger'>Vui lòng nhập đầy đủ</div>";
    } else {

        $check = $conn->query("SELECT * FROM users WHERE username='$username'");

        if($check->num_rows > 0){
            $msg = "<div class='alert alert-danger'>Tên đăng nhập đã tồn tại</div>";
        } else {

            $conn->query("
            INSERT INTO users(username,password,role,status)
            VALUES('$username','$password','student','pending')
            ");

            $msg = "<div class='alert alert-success'>
            Đăng ký thành công! Vui lòng chờ quản trị viên duyệt
            </div>";
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5" style="max-width:400px;">
<h3>📝 Đăng ký tài khoản</h3>

<?= $msg ?>

<form method="POST">
<input name="username" class="form-control mb-2" placeholder="Tên đăng nhập">
<input name="password" type="password" class="form-control mb-3" placeholder="Mật khẩu">
<button class="btn btn-primary w-100">Đăng ký</button>
</form>

<div class="mt-3 text-center">
<a href="login.php">Đã có tài khoản? Đăng nhập</a>
</div>
</div>
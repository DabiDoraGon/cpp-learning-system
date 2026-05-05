<?php
session_start();
include("includes/db.php");

$error = "";

if($_POST){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == "" || $password == ""){
        $error = "Vui lòng nhập đầy đủ thông tin";
    } else {

        $sql = "SELECT * FROM users 
                WHERE username='$username' 
                AND password='$password'";

        $res = $conn->query($sql);

        if($res->num_rows > 0){

            $user = $res->fetch_assoc();

            // ❗ CHẶN CHƯA DUYỆT
            if($user['status'] != 'active'){
                $error = "Tài khoản đang chờ quản trị viên duyệt";
            } else {

                // lưu session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // điều hướng
                if($user['role'] == 'admin'){
                    header("Location: admin/");
                } elseif($user['role'] == 'teacher'){
                    header("Location: teacher/");
                } else {
                    header("Location: student/");
                }
                exit;
            }

        } else {
            $error = "Sai tài khoản hoặc mật khẩu";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f1f5f9;
}

.box {
    background: white;
    padding: 30px;
    border-radius: 16px;
}
</style>

</head>
<body>

<div class="container mt-5" style="max-width:400px;">

<div class="box shadow">

<h3 class="text-center mb-3">🔐 Đăng nhập</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">

<label>Tên đăng nhập</label>
<input name="username" class="form-control mb-2">

<label>Mật khẩu</label>
<input type="password" name="password" class="form-control mb-3">

<button class="btn btn-primary w-100">Đăng nhập</button>

</form>

<hr>

<div class="text-center">
<a href="register.php">Chưa có tài khoản? Đăng ký</a>
</div>

</div>

</div>

</body>
</html>
<?php
session_start();
include("includes/db.php");

// chưa login thì đá về login
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$msg = "";

if($_POST){
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    $id = $_SESSION['user_id'];

    // lấy user hiện tại
    $user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

    // check mật khẩu cũ
    if($user['password'] != $old){
        $msg = "<div class='alert alert-danger'>❌ Sai mật khẩu cũ</div>";
    } else {

        // update mật khẩu mới
        $conn->query("UPDATE users SET password='$new' WHERE id=$id");

        $msg = "<div class='alert alert-success'>✅ Đổi mật khẩu thành công</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Đổi mật khẩu</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f1f5f9;">

<div class="container mt-5" style="max-width:400px;">

<h3>🔑 Đổi mật khẩu</h3>

<?= $msg ?>

<form method="POST">

<input type="password" name="old_password" class="form-control mb-2" placeholder="Mật khẩu cũ">

<input type="password" name="new_password" class="form-control mb-3" placeholder="Mật khẩu mới">

<button class="btn btn-primary w-100">Đổi mật khẩu</button>

</form>

<br>

<a href="javascript:history.back()" class="btn btn-secondary w-100">⬅️ Quay lại</a>

</div>

</body>
</html>
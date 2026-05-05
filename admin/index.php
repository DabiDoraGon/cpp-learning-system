<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

// lấy user
$users = $conn->query("SELECT * FROM users");

// tên admin
$username = "Quản trị viên";
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
    $u = $conn->query("SELECT username FROM users WHERE id=$id")->fetch_assoc();
    if($u) $username = $u['username'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản trị hệ thống</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body {
    background: #f1f5f9;
}

/* HEADER */
.header {
    background: white;
    padding: 15px 25px;
    border-bottom: 1px solid #e5e7eb;
}

/* USER */
.user-box {
    background: #f1f5f9;
    padding: 6px 12px;
    border-radius: 20px;
}

/* BUTTON */
.btn-soft {
    border-radius: 20px;
    padding: 6px 14px;
}

/* CONTENT */
.content-box {
    background: white;
    padding: 25px;
    border-radius: 16px;
}

</style>

</head>
<body>

<!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">

<div>
<h5 class="mb-0">⚙️ Bảng điều khiển quản trị</h5>
<small class="text-muted">Quản lý tài khoản hệ thống</small>
</div>

<div class="d-flex align-items-center gap-2">

<div class="user-box">
👤 <?= $username ?>
</div>

<a href="../change_password.php" class="btn btn-warning btn-soft">
🔑 Đổi mật khẩu
</a>

<a href="../logout.php" class="btn btn-danger btn-soft">
🚪 Đăng xuất
</a>

</div>

</div>

<div class="container mt-4">

<div class="content-box">

<div class="d-flex justify-content-between align-items-center mb-3">
<h4>👤 Danh sách người dùng</h4>

<a href="add_user.php" class="btn btn-primary">
➕ Thêm tài khoản
</a>
</div>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>Tên đăng nhập</th>
<th>Vai trò</th>
<th>Hành động</th>
</tr>

<?php while($u = $users->fetch_assoc()){ ?>
<tr>

<td><?= $u['username'] ?></td>

<td>
<?php
if($u['role'] == 'admin') echo "Quản trị viên";
elseif($u['role'] == 'teacher') echo "Giáo viên";
else echo "Học sinh";
?>
</td>

<td>

<a href="?delete=<?= $u['id'] ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Bạn có chắc muốn xóa?')">
Xóa
</a>

</td>

</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
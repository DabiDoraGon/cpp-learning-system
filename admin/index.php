<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}

/* ========= XỬ LÝ ========= */

// DUYỆT
if(isset($_GET['approve'])){
    $id = (int)$_GET['approve'];
    $conn->query("UPDATE users SET status='active' WHERE id=$id");
    header("Location: index.php");
    exit;
}

// TỪ CHỐI
if(isset($_GET['reject'])){
    $id = (int)$_GET['reject'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: index.php");
    exit;
}

// XÓA USER
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: index.php");
    exit;
}

// THÊM USER
if(isset($_POST['add_user'])){
    $u = $_POST['username'];
    $p = $_POST['password'];
    $r = $_POST['role'];

    $conn->query("INSERT INTO users(username,password,role,status)
                  VALUES('$u','$p','$r','active')");
    header("Location: index.php");
    exit;
}

// LẤY USER
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");

// tên admin
$username = "Admin";
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
body { background:#f1f5f9; }
.header { background:white;padding:15px 25px;border-bottom:1px solid #ddd;}
.content-box { background:white;padding:25px;border-radius:16px;}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header d-flex justify-content-between">
<h5>⚙️ Quản trị hệ thống</h5>

<div>
<a href="../change_password.php" class="btn btn-warning btn-sm">🔑</a>
<a href="../logout.php" class="btn btn-danger btn-sm">🚪</a>
</div>
</div>

<div class="container mt-4">

<div class="content-box">

<!-- ADD USER -->
<h5>➕ Thêm tài khoản</h5>

<form method="POST" class="row g-2 mb-4">

<div class="col">
<input name="username" class="form-control" placeholder="Username">
</div>

<div class="col">
<input name="password" class="form-control" placeholder="Password">
</div>

<div class="col">
<select name="role" class="form-control">
<option value="student">Học sinh</option>
<option value="teacher">Giáo viên</option>
<option value="admin">Admin</option>
</select>
</div>

<div class="col">
<button name="add_user" class="btn btn-primary">Thêm</button>
</div>

</form>

<!-- TABLE -->
<h5>👤 Danh sách tài khoản</h5>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Trạng thái</th>
<th>Hành động</th>
</tr>

<?php while($u = $users->fetch_assoc()){ ?>

<tr>

<td><?= $u['id'] ?></td>
<td><?= $u['username'] ?></td>

<td>
<?= $u['role'] ?>
</td>

<td>
<?= $u['status'] == 'active' ? 'Đã duyệt' : 'Chờ duyệt' ?>
</td>

<td>

<?php if($u['status'] == 'pending'){ ?>

<a href="?approve=<?= $u['id'] ?>" class="btn btn-success btn-sm">✔️</a>
<a href="?reject=<?= $u['id'] ?>" class="btn btn-danger btn-sm">❌</a>

<?php } else { ?>

<a href="?delete=<?= $u['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>
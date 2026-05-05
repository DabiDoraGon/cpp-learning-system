<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

// Lấy thống kê
$c1 = $conn->query("SELECT COUNT(*) as total FROM chapters")->fetch_assoc()['total'];
$c2 = $conn->query("SELECT COUNT(*) as total FROM lessons")->fetch_assoc()['total'];
$c3 = $conn->query("SELECT COUNT(*) as total FROM exercises")->fetch_assoc()['total'];
$c4 = $conn->query("SELECT COUNT(*) as total FROM submissions")->fetch_assoc()['total'];

// Tên user (optional)
$username = "Giáo viên";
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
<title>Bảng điều khiển giáo viên</title>

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

/* USER BOX */
.user-box {
    background: #f8fafc;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
}

/* BUTTON */
.btn-soft {
    border-radius: 20px;
    padding: 6px 14px;
}

/* CARD */
.card-box {
    border-radius: 16px;
    padding: 22px;
    color: white;
    transition: 0.25s;
    cursor: pointer;
}

.card-box:hover {
    transform: translateY(-5px);
    opacity: 0.95;
}

.card-link {
    text-decoration: none;
}

/* COLORS */
.bg-blue { background: #3b82f6; }
.bg-green { background: #10b981; }
.bg-yellow { background: #f59e0b; }
.bg-dark { background: #1e293b; }

/* STATS */
.stat {
    border-radius: 16px;
    padding: 25px;
}
</style>

</head>
<body>

<!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">

<div>
<h5 class="mb-0">📊 Bảng điều khiển giáo viên</h5>
<small class="text-muted">Quản lý hệ thống học tập C++</small>
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

<!-- MODULE -->
<div class="row g-4">

<div class="col-md-3">
<a href="chapter.php" class="card-link">
<div class="card-box bg-blue shadow">
<h5>📚 Quản lý chương</h5>
<p>Tạo và sắp xếp các chương học</p>
</div>
</a>
</div>

<div class="col-md-3">
<a href="lesson.php" class="card-link">
<div class="card-box bg-green shadow">
<h5>📖 Quản lý bài học</h5>
<p>Thêm và chỉnh sửa nội dung bài học</p>
</div>
</a>
</div>

<div class="col-md-3">
<a href="exercise.php" class="card-link">
<div class="card-box bg-yellow shadow text-dark">
<h5>📝 Quản lý bài tập</h5>
<p>Tạo bài tập cho học sinh</p>
</div>
</a>
</div>

<div class="col-md-3">
<a href="submissions.php" class="card-link">
<div class="card-box bg-dark shadow">
<h5>📥 Bài nộp của học sinh</h5>
<p>Xem và kiểm tra bài làm</p>
</div>
</a>
</div>

</div>

<hr class="my-4">

<!-- THỐNG KÊ -->
<div class="row text-center g-4">

<div class="col-md-3">
<div class="stat bg-blue text-white shadow">
<h3><?= $c1 ?></h3>
<p>Số chương</p>
</div>
</div>

<div class="col-md-3">
<div class="stat bg-green text-white shadow">
<h3><?= $c2 ?></h3>
<p>Số bài học</p>
</div>
</div>

<div class="col-md-3">
<div class="stat bg-yellow text-dark shadow">
<h3><?= $c3 ?></h3>
<p>Số bài tập</p>
</div>
</div>

<div class="col-md-3">
<div class="stat bg-dark text-white shadow">
<h3><?= $c4 ?></h3>
<p>Bài đã nộp</p>
</div>
</div>

</div>

</div>

</body>
</html>
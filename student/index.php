<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit;
}

// lấy chương
$chapters = $conn->query("SELECT * FROM chapters ORDER BY order_num");

// tên user
$username = "Học sinh";
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
<title>Học C++</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body {
    background: #f1f5f9;
}

/* SIDEBAR */
.sidebar {
    width: 260px;
    height: 100vh;
    background: #0f172a;
    color: white;
    padding: 20px;
    overflow-y: auto;
}

.sidebar a {
    display: block;
    padding: 8px;
    color: #cbd5e1;
    text-decoration: none;
    border-radius: 6px;
}

.sidebar a:hover {
    background: #1e293b;
    color: white;
}

.active-lesson {
    background: #3b82f6;
    color: white !important;
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
    font-size: 14px;
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

<div class="d-flex">

<!-- SIDEBAR -->
<div class="sidebar">

<h5>📘 Học lập trình C++</h5>

<hr>

<?php while($c = $chapters->fetch_assoc()) { ?>

<div class="mb-3">

<b><?= $c['title'] ?></b>

<?php
$lessons = $conn->query("SELECT * FROM lessons WHERE chapter_id=".$c['id']." ORDER BY order_num");
while($l = $lessons->fetch_assoc()) {
?>

<a href="?lesson=<?= $l['id'] ?>"
class="<?= (isset($_GET['lesson']) && $_GET['lesson']==$l['id']) ? 'active-lesson' : '' ?>">
→ <?= $l['title'] ?>
</a>

<?php } ?>

</div>

<?php } ?>

</div>

<!-- MAIN -->
<div class="flex-grow-1">

<!-- HEADER -->
<div class="header d-flex justify-content-between align-items-center">

<div>
<h5 class="mb-0">📖 Học lập trình C++</h5>
<small class="text-muted">Hệ thống tra cứu và luyện tập</small>
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

<!-- CONTENT -->
<div class="p-4">

<div class="content-box">

<?php
if(isset($_GET['lesson'])) {

$id = (int)$_GET['lesson'];
$lesson = $conn->query("SELECT * FROM lessons WHERE id=$id")->fetch_assoc();
?>

<h3><?= $lesson['title'] ?></h3>
<hr>

<div style="line-height:1.6;">
<?= $lesson['content'] ?>
</div>

<hr>

<h5>📝 Bài tập</h5>

<?php
$ex = $conn->query("SELECT * FROM exercises WHERE lesson_id=$id");

if($ex->num_rows == 0){
    echo "<p class='text-muted'>Chưa có bài tập</p>";
}

while($e = $ex->fetch_assoc()){
?>

<div class="card mb-3">
<div class="card-body">

<b><?= $e['title'] ?></b>
<p><?= $e['description'] ?></p>

<a href="submit.php?id=<?= $e['id'] ?>" class="btn btn-primary btn-sm">
Làm bài
</a>

</div>
</div>

<?php } ?>

<?php } else { ?>

<h4>👋 Chào mừng bạn!</h4>
<p class="text-muted">Hãy chọn bài học ở bên trái để bắt đầu.</p>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>
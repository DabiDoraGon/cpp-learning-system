<?php
session_start();
include(__DIR__ . "/../includes/db.php");

// 👉 giả lập user (sau này thay bằng login)
$user_id = 1;

// ❗ CHECK ID
if(!isset($_GET['id'])){
    die("Thiếu ID bài tập");
}

$exercise_id = (int)$_GET['id'];

// LẤY THÔNG TIN BÀI TẬP
$exercise = $conn->query("
SELECT exercises.*, lessons.title AS lesson_name 
FROM exercises 
JOIN lessons ON exercises.lesson_id = lessons.id
WHERE exercises.id = $exercise_id
")->fetch_assoc();

if(!$exercise){
    die("Bài tập không tồn tại");
}

// SUBMIT
$message = "";

if($_POST){
    $code = $conn->real_escape_string($_POST['code']);

    if(trim($code) == ""){
        $message = "<div class='alert alert-danger'>Không được để trống code</div>";
    } else {
        $conn->query("
        INSERT INTO submissions(user_id, exercise_id, code)
        VALUES($user_id, $exercise_id, '$code')
        ");

        $message = "<div class='alert alert-success'>✅ Nộp bài thành công!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Nộp bài</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f5f7fb;
}

.container-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
}

.code-box {
    background: #0f172a;
    color: #22c55e;
    padding: 15px;
    border-radius: 8px;
    font-family: monospace;
}
</style>

</head>
<body>

<div class="container mt-4">

<div class="container-box">

<h3>📝 <?= $exercise['title'] ?></h3>
<p class="text-muted">Bài học: <?= $exercise['lesson_name'] ?></p>

<hr>

<p><?= $exercise['description'] ?></p>

<?= $message ?>

<form method="POST">

<label><b>Code của bạn:</b></label>

<textarea name="code" class="form-control mt-2 mb-3" rows="12"
style="background:#0f172a;color:#22c55e;font-family:monospace;"
placeholder="// Nhập code C++ ở đây..."></textarea>

<button class="btn btn-primary">🚀 Nộp bài</button>

<a href="index.php" class="btn btn-secondary">⬅️ Quay lại</a>

</form>

<hr>

<a href="my_submissions.php" class="btn btn-dark">
📥 Xem bài đã nộp
</a>

</div>

</div>

</body>
</html>
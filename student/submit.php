<?php
session_start();
include(__DIR__ . "/../includes/db.php");

// giả lập user (nếu chưa login)
$user_id = 1;

if($_POST){
    $code = $_POST['code'];
    $exercise_id = (int)$_POST['exercise_id'];

    $conn->query("INSERT INTO submissions(user_id, exercise_id, code)
                  VALUES($user_id, $exercise_id, '$code')");

    echo "<div class='alert alert-success'>Nộp bài thành công!</div>";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>📤 Nộp bài</h3>

<form method="POST">

<input type="hidden" name="exercise_id" value="<?= $_GET['id'] ?>">

<textarea name="code" class="form-control mb-3" rows="10" placeholder="Nhập code C++ của bạn..."></textarea>

<button class="btn btn-primary">Nộp bài</button>

</form>

<a href="my_submissions.php" class="btn btn-secondary mt-3">Xem bài đã nộp</a>

</div>
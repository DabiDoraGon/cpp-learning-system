<?php
session_start();
include(__DIR__ . "/../includes/db.php");

// check student
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$exercise_id = (int)$_GET['id'];

// lấy bài tập
$exercise = $conn->query("SELECT * FROM exercises WHERE id=$exercise_id")->fetch_assoc();

$message = "";

if($_POST){

    $code = $_POST['code'];
    $output = trim($_POST['output']); // học sinh nhập output

    $expected = trim($exercise['test_output']);

    // CHẤM ĐIỂM
    if($output === $expected){
        $score = 10;
        $result = "Đúng";
    } else {
        $score = 0;
        $result = "Sai";
    }

    // lưu DB
    $conn->query("
    INSERT INTO submissions(user_id, exercise_id, code, score, result)
    VALUES($user_id, $exercise_id, '$code', $score, '$result')
    ");

    $message = "
    <div class='alert alert-info mt-3'>
        <b>Kết quả:</b> $result <br>
        <b>Điểm:</b> $score
    </div>
    ";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Nộp bài</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f1f5f9; }

.box {
    background:white;
    padding:25px;
    border-radius:16px;
}
</style>

</head>

<body>

<div class="container mt-4">

<div class="box shadow">

<h3>📝 <?= $exercise['title'] ?></h3>

<hr>

<p><b>📥 Input:</b></p>
<pre><?= $exercise['test_input'] ?></pre>

<p><b>📤 Output cần đạt:</b></p>
<pre><?= $exercise['test_output'] ?></pre>

<hr>

<form method="POST">

<label>Code của bạn</label>
<textarea name="code" class="form-control mb-2" rows="6"></textarea>

<label>Output chương trình</label>
<input name="output" class="form-control mb-3" placeholder="Nhập kết quả chương trình">

<button class="btn btn-primary">🚀 Nộp bài</button>

</form>

<?= $message ?>

</div>

</div>

</body>
</html>
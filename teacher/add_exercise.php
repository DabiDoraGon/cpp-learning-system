<?php
session_start();
include(__DIR__ . "/../includes/db.php");

// check teacher
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

$msg = "";

// lấy danh sách lesson
$lessons = $conn->query("SELECT * FROM lessons");

if($_POST){

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $lesson_id = (int)$_POST['lesson_id'];

    $test_input = $_POST['test_input'];
    $test_output = $_POST['test_output'];

    if($title == "" || $lesson_id == 0){
        $msg = "<div class='alert alert-danger'>Vui lòng nhập đầy đủ</div>";
    } else {

        $conn->query("
        INSERT INTO exercises(title, description, lesson_id, test_input, test_output)
        VALUES('$title','$desc',$lesson_id,'$test_input','$test_output')
        ");

        $msg = "<div class='alert alert-success'>Thêm bài tập thành công</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm bài tập</title>

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

<h3>📝 Thêm bài tập</h3>

<?= $msg ?>

<form method="POST">

<label>Tiêu đề</label>
<input name="title" class="form-control mb-2">

<label>Mô tả</label>
<textarea name="description" class="form-control mb-2"></textarea>

<label>Chọn bài học</label>
<select name="lesson_id" class="form-control mb-3">
<option value="0">-- Chọn bài học --</option>

<?php while($l = $lessons->fetch_assoc()){ ?>
<option value="<?= $l['id'] ?>">
<?= $l['title'] ?>
</option>
<?php } ?>

</select>

<hr>

<h5>🧪 Test case</h5>

<label>Input mẫu</label>
<textarea name="test_input" class="form-control mb-2"
placeholder="Ví dụ: 2 3"></textarea>

<label>Output đúng</label>
<textarea name="test_output" class="form-control mb-3"
placeholder="Ví dụ: 5"></textarea>

<button class="btn btn-primary">Tạo bài tập</button>

<a href="exercise.php" class="btn btn-secondary">⬅️ Quay lại</a>

</form>

</div>

</div>

</body>
</html>
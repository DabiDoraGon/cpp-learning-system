<?php
session_start();
include(__DIR__ . "/../includes/db.php");

// check teacher
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

// lấy danh sách lesson
$lessons = $conn->query("SELECT * FROM lessons");

if($_POST){

    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $lesson_id = (int)$_POST['lesson_id'];

    $test_input = trim($_POST['test_input']);
    $test_output = trim($_POST['test_output']);

    // validate
    if($title != "" && $lesson_id != 0){

        $conn->query("
        INSERT INTO exercises(
            title,
            description,
            lesson_id,
            test_input,
            test_output
        )
        VALUES(
            '$title',
            '$desc',
            $lesson_id,
            '$test_input',
            '$test_output'
        )
        ");

        // quay lại trang quản lí bài tập
        header("Location: exercise.php");
        exit;
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

body{
    background:#f1f5f9;
}

.box{
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

<a href="exercise.php" class="btn btn-secondary mb-3">
⬅️ Quay lại
</a>

<form method="POST">

<label>Tiêu đề</label>

<input
name="title"
class="form-control mb-2"
required>

<label>Mô tả</label>

<textarea
name="description"
class="form-control mb-2"></textarea>

<label>Chọn bài học</label>

<select
name="lesson_id"
class="form-control mb-3"
required>

<option value="0">
-- Chọn bài học --
</option>

<?php while($l = $lessons->fetch_assoc()){ ?>

<option value="<?= $l['id'] ?>">
<?= $l['title'] ?>
</option>

<?php } ?>

</select>

<hr>

<h5>🧪 Test case</h5>

<label>Input mẫu</label>

<textarea
name="test_input"
class="form-control mb-2"
placeholder="Ví dụ: 2 3"></textarea>

<label>Output đúng</label>

<textarea
name="test_output"
class="form-control mb-3"
placeholder="Ví dụ: 5"></textarea>

<button class="btn btn-primary">
💾 Tạo bài tập
</button>

</form>

</div>

</div>

</body>
</html>
<?php
include(__DIR__ . "/../includes/db.php");

if($_POST){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $lesson = (int)$_POST['lesson_id'];

    $conn->query("INSERT INTO exercises(title,description,lesson_id)
                  VALUES('$title','$desc',$lesson)");

    header("Location: exercise.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>➕ Thêm bài tập</h3>

<form method="POST">

<input name="title" class="form-control mb-2" placeholder="Tên bài tập" required>

<select name="lesson_id" class="form-control mb-2">
<?php
$res = $conn->query("SELECT * FROM lessons ORDER BY order_num");
while($l = $res->fetch_assoc()){
    echo "<option value='".$l['id']."'>".$l['title']."</option>";
}
?>
</select>

<textarea name="description" class="form-control mb-2" rows="5" placeholder="Mô tả bài tập"></textarea>

<button class="btn btn-success">Lưu</button>

</form>

</div>
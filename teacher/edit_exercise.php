<?php
include(__DIR__ . "/../includes/db.php");

$id = (int)$_GET['id'];

$ex = $conn->query("SELECT * FROM exercises WHERE id=$id")->fetch_assoc();

if(!$ex){
    die("Không tìm thấy bài tập");
}

if($_POST){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $lesson = (int)$_POST['lesson_id'];

    $conn->query("UPDATE exercises 
                  SET title='$title',
                      description='$desc',
                      lesson_id=$lesson
                  WHERE id=$id");

    header("Location: exercise.php");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>✏️ Sửa bài tập</h3>

<form method="POST">

<input name="title" class="form-control mb-2" value="<?= $ex['title'] ?>">

<select name="lesson_id" class="form-control mb-2">
<?php
$res = $conn->query("SELECT * FROM lessons ORDER BY order_num");
while($l = $res->fetch_assoc()){
    $selected = ($l['id'] == $ex['lesson_id']) ? "selected" : "";
    echo "<option value='".$l['id']."' $selected>".$l['title']."</option>";
}
?>
</select>

<textarea name="description" class="form-control mb-2"><?= $ex['description'] ?></textarea>

<button class="btn btn-warning">Cập nhật</button>

</form>

</div>
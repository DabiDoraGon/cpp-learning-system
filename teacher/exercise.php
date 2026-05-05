<?php
include(__DIR__ . "/../includes/db.php");

// Xóa
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM exercises WHERE id=$id");

    header("Location: exercise.php");
    exit;
}

// Lấy danh sách
$sql = "SELECT exercises.*, lessons.title AS lesson_name
        FROM exercises
        JOIN lessons ON exercises.lesson_id = lessons.id
        ORDER BY exercises.id DESC";

$res = $conn->query($sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h2>📝 Quản lý bài tập</h2>

<a href="add_exercise.php" class="btn btn-success mt-3">+ Thêm bài tập</a>
<a href="index.php" class="btn btn-secondary mt-3">⬅️ Quay lại</a>

<hr>

<table class="table table-bordered table-hover">
<tr class="table-dark">
<th>Tên bài tập</th>
<th>Bài học</th>
<th>Hành động</th>
</tr>

<?php while($e = $res->fetch_assoc()){ ?>
<tr>

<td><?= $e['title'] ?></td>
<td><?= $e['lesson_name'] ?></td>

<td>
<a href="edit_exercise.php?id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>

<a href="?delete=<?= $e['id'] ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Xóa bài tập này?')">
   ❌ Xóa
</a>
</td>

</tr>
<?php } ?>

</table>

</div>
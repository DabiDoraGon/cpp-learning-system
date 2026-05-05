<?php
include(__DIR__ . "/../includes/db.php");

// XÓA BÀI HỌC
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $conn->query("DELETE FROM lessons WHERE id=$id");

    // redirect để tránh xóa lại khi refresh
    header("Location: lesson.php");
    exit;
}

// LẤY DANH SÁCH BÀI HỌC
$sql = "SELECT lessons.*, chapters.title AS chapter_name
        FROM lessons
        JOIN chapters ON lessons.chapter_id = chapters.id
        ORDER BY chapters.order_num, lessons.order_num";

$lessons = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý bài học</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.table td, .table th {
    vertical-align: middle;
}
</style>

</head>
<body>

<div class="container mt-4">

<h2>📚 Quản lý bài học</h2>

<a href="add_lesson.php" class="btn btn-success mt-3">+ Thêm bài học</a>
<a href="index.php" class="btn btn-secondary mt-3">⬅️ Quay lại</a>

<hr>

<table class="table table-bordered table-hover">

<tr class="table-dark">
    <th>Tên bài</th>
    <th>Chương</th>
    <th>Thứ tự</th>
    <th width="180">Hành động</th>
</tr>

<?php while($l = $lessons->fetch_assoc()){ ?>
<tr>
    

<td>
    <b><?= $l['title'] ?></b>
</td>

<td><?= $l['chapter_name'] ?></td>

<td><?= $l['order_num'] ?></td>

<td>
    <a href="edit_lesson.php?id=<?= $l['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>

    <a href="?delete=<?= $l['id'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Bạn chắc chắn muốn xóa bài này?')">
       ❌ Xóa
    </a>
</td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>
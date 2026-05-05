<?php
include(__DIR__ . "/../includes/db.php");

// XÓA CHƯƠNG
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    // Xóa lesson thuộc chương trước (tránh lỗi)
    $conn->query("DELETE FROM lessons WHERE chapter_id=$id");

    // Xóa chương
    $conn->query("DELETE FROM chapters WHERE id=$id");

    header("Location: chapter.php");
    exit;
}

// LẤY DANH SÁCH CHƯƠNG
$chapters = $conn->query("SELECT * FROM chapters ORDER BY order_num");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý chương</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.table td, .table th {
    vertical-align: middle;
}
</style>

</head>
<body>

<div class="container mt-4">

<h2>📚 Quản lý chương</h2>

<a href="add_chapter.php" class="btn btn-primary mt-3">+ Thêm chương</a>
<a href="index.php" class="btn btn-secondary mt-3">⬅️ Dashboard</a>

<hr>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>Tên chương</th>
<th>Thứ tự</th>
<th width="180">Hành động</th>
</tr>

<?php while($c = $chapters->fetch_assoc()){ ?>
<tr>

<td>
    <b><?= $c['title'] ?></b>
</td>

<td><?= $c['order_num'] ?></td>

<td>
    <a href="edit_chapter.php?id=<?= $c['id'] ?>" 
       class="btn btn-warning btn-sm">✏️ Sửa</a>

    <a href="?delete=<?= $c['id'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Bạn chắc chắn muốn xóa chương này?')">
       ❌ Xóa
    </a>
</td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>
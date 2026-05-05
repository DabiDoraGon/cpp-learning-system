<?php
include(__DIR__ . "/../includes/db.php");

// Xóa chương
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM chapters WHERE id=$id");
}

$chapters = $conn->query("SELECT * FROM chapters ORDER BY order_num");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h2>👨‍🏫 Quản lý chương</h2>

<a href="add_chapter.php" class="btn btn-primary mt-3">+ Thêm chương</a>

<hr>

<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Tên chương</th>
<th>Thứ tự</th>
<th>Hành động</th>
</tr>

<?php while($c = $chapters->fetch_assoc()){ ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['title'] ?></td>
<td><?= $c['order_num'] ?></td>
<td>
    <a href="edit_chapter.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
    <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm"
       onclick="return confirm('Xóa chương này?')">Xóa</a>
</td>
</tr>
<?php } ?>

</table>

</div>
<?php
include(__DIR__ . "/../includes/db.php");

$id = (int)$_GET['id'];
$chapter = $conn->query("SELECT * FROM chapters WHERE id=$id")->fetch_assoc();

if($_POST){
    $title = $_POST['title'];
    $order = $_POST['order_num'];

    $conn->query("UPDATE chapters 
                  SET title='$title', order_num='$order'
                  WHERE id=$id");

    header("Location: index.php");
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>✏️ Sửa chương</h3>

<form method="POST">

<input name="title" class="form-control mb-2" value="<?= $chapter['title'] ?>">

<input name="order_num" class="form-control mb-2" value="<?= $chapter['order_num'] ?>">

<button class="btn btn-warning">Cập nhật</button>

</form>

</div>
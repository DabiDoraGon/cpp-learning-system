<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if($_POST){

    $title = trim($_POST['title']);
    $order = (int)$_POST['order_num'];

    // validate
    if($title != ""){

        $conn->query("
        INSERT INTO chapters(title, order_num)
        VALUES('$title', '$order')
        ");

        // quay lại quản lí chương
        header("Location: chapter.php");
        exit;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>➕ Thêm chương</h3>

<a href="chapter.php" class="btn btn-secondary mb-3">
⬅️ Quay lại
</a>

<form method="POST">

<input
name="title"
class="form-control mb-2"
placeholder="Tên chương"
required>

<input
name="order_num"
type="number"
class="form-control mb-3"
placeholder="Thứ tự"
required>

<button class="btn btn-primary">
💾 Lưu
</button>

</form>

</div>
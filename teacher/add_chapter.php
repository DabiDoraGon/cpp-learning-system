<?php
include(__DIR__ . "/../includes/db.php");

if($_POST){
    $title = $_POST['title'];
    $order = $_POST['order_num'];

    $conn->query("INSERT INTO chapters(title, order_num)
                  VALUES('$title','$order')");

    echo "Thêm chương thành công!";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>➕ Thêm chương</h3>

<form method="POST">

<input name="title" class="form-control mb-2" placeholder="Tên chương">

<input name="order_num" class="form-control mb-2" placeholder="Thứ tự">

<button class="btn btn-primary">Lưu</button>

</form>

</div>
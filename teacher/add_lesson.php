<?php
include(__DIR__ . "/../includes/db.php");

if($_POST){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $chapter = $_POST['chapter_id'];
    $order = $_POST['order_num'];

    $conn->query("INSERT INTO lessons(title,content,chapter_id,order_num)
                  VALUES('$title','$content','$chapter','$order')");

    echo "Thêm bài học thành công!";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>➕ Thêm bài học</h3>

<form method="POST">

<input name="title" class="form-control mb-2" placeholder="Tên bài học">

<input name="order_num" class="form-control mb-2" placeholder="Thứ tự">

<select name="chapter_id" class="form-control mb-2">
<?php
$res = $conn->query("SELECT * FROM chapters");
while($c = $res->fetch_assoc()){
    echo "<option value='".$c['id']."'>".$c['title']."</option>";
}
?>
</select>

<textarea name="content" class="form-control mb-2" rows="5" placeholder="Nội dung"></textarea>

<button class="btn btn-success">Lưu</button>

</form>

</div>
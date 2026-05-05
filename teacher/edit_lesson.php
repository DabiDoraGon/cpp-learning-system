<?php
include(__DIR__ . "/../includes/db.php");

$id = (int)$_GET['id'];

$lesson = $conn->query("SELECT * FROM lessons WHERE id=$id")->fetch_assoc();

if($_POST){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $chapter = (int)$_POST['chapter_id'];
    $order = (int)$_POST['order_num'];

    $conn->query("UPDATE lessons 
                  SET title='$title', content='$content', 
                      chapter_id='$chapter', order_num='$order'
                  WHERE id=$id");

    header("Location: lesson.php");
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>✏️ Sửa bài học</h3>

<form method="POST">

<input name="title" class="form-control mb-2" value="<?= $lesson['title'] ?>">

<input name="order_num" class="form-control mb-2" value="<?= $lesson['order_num'] ?>">

<select name="chapter_id" class="form-control mb-2">
<?php
$res = $conn->query("SELECT * FROM chapters ORDER BY order_num");
while($c = $res->fetch_assoc()){
    $selected = ($c['id'] == $lesson['chapter_id']) ? "selected" : "";
    echo "<option value='".$c['id']."' $selected>".$c['title']."</option>";
}
?>
</select>

<textarea name="content" class="form-control mb-2" rows="5"><?= $lesson['content'] ?></textarea>

<button class="btn btn-warning">Cập nhật</button>

</form>

</div>
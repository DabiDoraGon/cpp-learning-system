<?php
include(__DIR__ . "/../includes/db.php");

// Lấy ID
$id = (int)$_GET['id'];

// Lấy dữ liệu bài học
$lesson = $conn->query("SELECT * FROM lessons WHERE id=$id")->fetch_assoc();

// Nếu không tồn tại
if(!$lesson){
    die("Bài học không tồn tại");
}

// Khi submit
if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $chapter = (int)$_POST['chapter_id'];
    $order = (int)$_POST['order_num'];

    $conn->query("UPDATE lessons 
                  SET title='$title',
                      content='$content',
                      chapter_id=$chapter,
                      order_num=$order
                  WHERE id=$id");

    header("Location: lesson.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa bài học</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.container {
    max-width: 600px;
}
</style>

</head>
<body>

<div class="container mt-4">

<h3>✏️ Sửa bài học</h3>

<form method="POST">

    <!-- Tên bài -->
    <label>Tên bài học</label>
    <input name="title" class="form-control mb-3" 
           value="<?= $lesson['title'] ?>" required>

    <!-- Thứ tự -->
    <label>Thứ tự hiển thị</label>
    <input name="order_num" type="number" class="form-control mb-3" 
           value="<?= $lesson['order_num'] ?>" required>

    <!-- Chọn chương -->
    <label>Chọn chương</label>
    <select name="chapter_id" class="form-control mb-3">
        <?php
        $res = $conn->query("SELECT * FROM chapters ORDER BY order_num");
        while ($c = $res->fetch_assoc()) {
            $selected = ($c['id'] == $lesson['chapter_id']) ? "selected" : "";
            echo "<option value='".$c['id']."' $selected>".$c['title']."</option>";
        }
        ?>
    </select>

    <!-- Nội dung -->
    <label>Nội dung bài học</label>
    <textarea name="content" class="form-control mb-3" rows="6"><?= $lesson['content'] ?></textarea>

    <!-- Nút -->
    <button class="btn btn-warning">💾 Cập nhật</button>
    <a href="lesson.php" class="btn btn-secondary">⬅️ Quay lại</a>

</form>

</div>

</body>
</html>
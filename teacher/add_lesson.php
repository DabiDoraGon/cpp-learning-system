<?php
include(__DIR__ . "/../includes/db.php");

// Xử lý khi submit form
if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $chapter = (int)$_POST['chapter_id'];
    $order = (int)$_POST['order_num'];

    // Insert DB
    $conn->query("INSERT INTO lessons(title,content,chapter_id,order_num)
                  VALUES('$title','$content',$chapter,$order)");

    // Redirect tránh submit lại
    header("Location: lesson.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm bài học</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.container {
    max-width: 600px;
}
</style>

</head>
<body>

<div class="container mt-4">

<h3>➕ Thêm bài học</h3>

<form method="POST">

    <!-- Tên bài -->
    <label>Tên bài học</label>
    <input name="title" class="form-control mb-3" required>

    <!-- Thứ tự -->
    <label>Thứ tự hiển thị</label>
    <input name="order_num" type="number" class="form-control mb-3" required>

    <!-- Chọn chương -->
    <label>Chọn chương</label>
    <select name="chapter_id" class="form-control mb-3" required>
        <?php
        $res = $conn->query("SELECT * FROM chapters ORDER BY order_num");
        while ($c = $res->fetch_assoc()) {
            echo "<option value='".$c['id']."'>".$c['title']."</option>";
        }
        ?>
    </select>

    <!-- Nội dung -->
    <label>Nội dung bài học</label>
    <textarea name="content" class="form-control mb-3" rows="6" required></textarea>

    <!-- Nút -->
    <button class="btn btn-success">💾 Lưu bài học</button>
    <a href="lesson.php" class="btn btn-secondary">⬅️ Quay lại</a>

</form>

</div>

</body>
</html>
<?php
include(__DIR__ . "/../includes/db.php");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h2>👨‍🏫 Trang Giáo Viên</h2>

<a href="add_chapter.php" class="btn btn-primary mt-3">+ Thêm chương</a>
<a href="add_lesson.php" class="btn btn-success mt-3">+ Thêm bài học</a>

<hr>

<h4>📚 Danh sách chương</h4>

<?php
$chapters = $conn->query("SELECT * FROM chapters ORDER BY order_num");

while($c = $chapters->fetch_assoc()){
    echo "<div class='p-2 border mb-2'><b>".$c['title']."</b></div>";
}
?>

</div>
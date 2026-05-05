<?php
include(__DIR__ . "/../includes/db.php");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Teacher Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.card {
    transition: 0.2s;
}
.card:hover {
    transform: scale(1.03);
}
</style>

</head>
<body>

<div class="container mt-4">

<h2>👨‍🏫 Dashboard Giáo Viên</h2>
<p class="text-muted">Quản lý nội dung học tập</p>

<div class="row mt-4">

    <!-- CHAPTER -->
    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h4>📚 Chương</h4>
            <p>Quản lý các chương học</p>
            <a href="chapter.php" class="btn btn-primary">Quản lý chương</a>
        </div>
    </div>

    <!-- LESSON -->
    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h4>📖 Bài học</h4>
            <p>Thêm, sửa, xóa bài học</p>
            <a href="lesson.php" class="btn btn-success">Quản lý bài học</a>
        </div>
    </div>

    <!-- EXERCISE -->
    <div class="col-md-4">
        <div class="card p-3 shadow">
            <h4>📝 Bài tập</h4>
            <p>Quản lý bài tập</p>
            <a href="exercise.php" class="btn btn-warning">Quản lý bài tập</a>
        </div>
    </div>

</div>

<hr>

<!-- QUICK STATS -->
<div class="row text-center mt-4">

<?php
$c1 = $conn->query("SELECT COUNT(*) as total FROM chapters")->fetch_assoc()['total'];
$c2 = $conn->query("
SELECT COUNT(*) as total 
FROM lessons 
JOIN chapters ON lessons.chapter_id = chapters.id
")->fetch_assoc()['total'];
$c3 = $conn->query("SELECT COUNT(*) as total FROM exercises")->fetch_assoc()['total'];
?>

<div class="col-md-4">
    <div class="alert alert-primary">
        <h4><?= $c1 ?></h4>
        <p>Chương</p>
    </div>
</div>

<div class="col-md-4">
    <div class="alert alert-success">
        <h4><?= $c2 ?></h4>
        <p>Bài học</p>
    </div>
</div>

<div class="col-md-4">
    <div class="alert alert-warning">
        <h4><?= $c3 ?></h4>
        <p>Bài tập</p>
    </div>
</div>

</div>

</div>

</body>
</html>
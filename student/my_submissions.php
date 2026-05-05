<?php
include(__DIR__ . "/../includes/db.php");

$user_id = 1;

$sql = "SELECT submissions.*, exercises.title AS ex_name, lessons.title AS lesson_name
        FROM submissions
        JOIN exercises ON submissions.exercise_id = exercises.id
        JOIN lessons ON exercises.lesson_id = lessons.id
        WHERE submissions.user_id = $user_id
        ORDER BY submissions.created_at DESC";

$res = $conn->query($sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>📚 Bài đã nộp</h3>

<?php while($s = $res->fetch_assoc()){ ?>

<div class="card mb-3">
    <div class="card-header">
        <b><?= $s['ex_name'] ?></b> 
        <span class="text-muted">| <?= $s['lesson_name'] ?></span>
    </div>

    <div class="card-body">
        <pre style="background:#111;color:#0f0;padding:10px;border-radius:5px;">
<?= htmlspecialchars($s['code']) ?>
        </pre>
    </div>

    <div class="card-footer text-muted">
        ⏱ <?= $s['created_at'] ?>
    </div>
</div>

<?php } ?>

</div>
<?php
include(__DIR__ . "/../includes/db.php");

$sql = "SELECT submissions.*, 
               exercises.title AS ex_name,
               lessons.title AS lesson_name,
               users.username
        FROM submissions
        JOIN exercises ON submissions.exercise_id = exercises.id
        JOIN lessons ON exercises.lesson_id = lessons.id
        LEFT JOIN users ON submissions.user_id = users.id
        ORDER BY submissions.created_at DESC";

$res = $conn->query($sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h2>📥 Bài học sinh đã nộp</h2>

<a href="index.php" class="btn btn-secondary mb-3">⬅️ Dashboard</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">
<th>Học sinh</th>
<th>Bài tập</th>
<th>Bài học</th>
<th>Code</th>
<th>Thời gian</th>
</tr>

<?php while($s = $res->fetch_assoc()){ ?>

<tr>

<td><?= $s['username'] ?? 'User #'.$s['user_id'] ?></td>

<td><?= $s['ex_name'] ?></td>

<td><?= $s['lesson_name'] ?></td>

<td>
<pre style="max-height:150px; overflow:auto; background:#111; color:#0f0;">
<?= htmlspecialchars($s['code']) ?>
</pre>
</td>

<td><?= $s['created_at'] ?></td>

</tr>

<?php } ?>

</table>

</div>
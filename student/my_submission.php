<?php
include(__DIR__ . "/../includes/db.php");

$user_id = 1;

$sql = "SELECT submissions.*, exercises.title AS ex_name
        FROM submissions
        JOIN exercises ON submissions.exercise_id = exercises.id
        WHERE submissions.user_id = $user_id
        ORDER BY submissions.id DESC";

$res = $conn->query($sql);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>📚 Bài đã nộp</h3>

<table class="table table-bordered">

<tr>
<th>Bài tập</th>
<th>Code</th>
<th>Thời gian</th>
</tr>

<?php while($s = $res->fetch_assoc()){ ?>
<tr>

<td><?= $s['ex_name'] ?></td>

<td>
<pre style="max-height:150px; overflow:auto;">
<?= htmlspecialchars($s['code']) ?>
</pre>
</td>

<td><?= $s['created_at'] ?></td>

</tr>
<?php } ?>

</table>

</div>
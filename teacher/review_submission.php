<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

$id = (int)$_GET['id'];

$submission = $conn->query("
SELECT submissions.*, users.username, exercises.title AS ex_name
FROM submissions
JOIN users ON submissions.user_id = users.id
JOIN exercises ON submissions.exercise_id = exercises.id
WHERE submissions.id = $id
")->fetch_assoc();

$message = "";

if($_POST){

    $score = (int)$_POST['score'];
    $feedback = $conn->real_escape_string($_POST['feedback']);

    $conn->query("
    UPDATE submissions
    SET score=$score, feedback='$feedback'
    WHERE id=$id
    ");

    $message = "
    <div class='alert alert-success mt-3'>
        Đã chấm bài thành công
    </div>
    ";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>📝 Chấm bài học sinh</h3>

<?= $message ?>

<div class="card mt-3">

<div class="card-header">
<b><?= $submission['username'] ?></b> | <?= $submission['ex_name'] ?>
</div>

<div class="card-body">

<p><b>💻 Code:</b></p>

<pre style="background:#111;color:#0f0;padding:10px;border-radius:5px;">
<?= htmlspecialchars($submission['code']) ?>
</pre>

<p><b>📤 Output:</b> <?= htmlspecialchars($submission['output']) ?></p>

<form method="POST">

<label>⭐ Điểm</label>
<input type="number" name="score"
class="form-control mb-3"
value="<?= $submission['score'] ?>"
min="0" max="10">

<label>💬 Nhận xét</label>

<textarea name="feedback"
class="form-control mb-3"
rows="5"><?= $submission['feedback'] ?></textarea>

<button class="btn btn-primary">
💾 Lưu chấm bài
</button>

</form>

</div>
</div>
</div>
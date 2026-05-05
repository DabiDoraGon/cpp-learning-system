<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

$id = (int)$_GET['id'];

// lấy dữ liệu
$lesson = $conn->query("SELECT * FROM lessons WHERE id=$id")->fetch_assoc();
$chapters = $conn->query("SELECT * FROM chapters");

$msg = "";

if($_POST){
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $chapter_id = (int)$_POST['chapter_id'];

    if($title == "" || $chapter_id == 0){
        $msg = "<div class='alert alert-danger'>Vui lòng nhập đầy đủ</div>";
    } else {

        $conn->query("
        UPDATE lessons 
        SET title='$title', content='$content', chapter_id=$chapter_id
        WHERE id=$id
        ");

        $msg = "<div class='alert alert-success'>Cập nhật thành công</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chỉnh sửa bài học</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f1f5f9;
}

/* CARD */
.box {
    background: white;
    padding: 30px;
    border-radius: 18px;
}

/* HEADER */
.header {
    font-weight: 600;
}

/* BUTTON */
.btn-soft {
    border-radius: 20px;
    padding: 6px 14px;
}
</style>
</head>

<body>

<div class="container mt-4">

<div class="box shadow">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>
<h3 class="header">✏️ Chỉnh sửa bài học</h3>
<small class="text-muted">Cập nhật nội dung bài học</small>
</div>

<a href="lesson.php" class="btn btn-secondary btn-soft">⬅️ Quay lại</a>

</div>

<?= $msg ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">📌 Tiêu đề</label>
<input name="title" value="<?= $lesson['title'] ?>" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">📚 Chương</label>
<select name="chapter_id" class="form-control">
<?php while($c = $chapters->fetch_assoc()){ ?>
<option value="<?= $c['id'] ?>" 
<?= ($lesson['chapter_id'] == $c['id']) ? 'selected' : '' ?>>
<?= $c['title'] ?>
</option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label class="form-label">📝 Nội dung bài học</label>
<textarea name="content" id="editor">
<?= htmlspecialchars($lesson['content']) ?>
</textarea>
</div>

<div class="d-flex gap-2">

<button class="btn btn-primary btn-soft">
💾 Lưu thay đổi
</button>

<button type="reset" class="btn btn-outline-secondary btn-soft">
🔄 Reset
</button>

</div>

</form>

</div>

</div>

<!-- CKEDITOR FULL -->
<script src="https://cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

<script>
CKEDITOR.replace('editor', {
    height: 450,

    toolbar: [
        { name: 'document', items: ['Source'] },
        { name: 'clipboard', items: ['Undo','Redo'] },
        { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike'] },
        { name: 'paragraph', items: ['NumberedList','BulletedList','Blockquote'] },
        { name: 'styles', items: ['Styles','Format','Font','FontSize'] },
        { name: 'colors', items: ['TextColor','BGColor'] },
        { name: 'align', items: ['JustifyLeft','JustifyCenter','JustifyRight'] },
        { name: 'insert', items: ['Image','Table','HorizontalRule','CodeSnippet'] }
    ]
});
</script>

</body>
</html>
<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit;
}

$msg = "";
$chapters = $conn->query("SELECT * FROM chapters");

if($_POST){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $chapter_id = (int)$_POST['chapter_id'];

    $conn->query("
    INSERT INTO lessons(title, content, chapter_id)
    VALUES('$title','$content',$chapter_id)
    ");

    $msg = "<div class='alert alert-success'>Đã lưu bài học</div>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm bài học</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f1f5f9; }

.box {
    background:white;
    padding:25px;
    border-radius:18px;
}

.preview {
    background:white;
    padding:20px;
    border-radius:16px;
    height:600px;
    overflow:auto;
}
</style>
</head>

<body>

<div class="container mt-4">

<div class="row">

<!-- EDITOR -->
<div class="col-md-7">
<div class="box shadow">

<h4>📝 Soạn bài</h4>

<?= $msg ?>

<form method="POST">

<input name="title" placeholder="Tiêu đề" class="form-control mb-2">

<select name="chapter_id" class="form-control mb-3">
<?php while($c = $chapters->fetch_assoc()){ ?>
<option value="<?= $c['id'] ?>"><?= $c['title'] ?></option>
<?php } ?>
</select>

<textarea name="content" id="editor"></textarea>

<br>

<button class="btn btn-primary">💾 Lưu</button>

</form>

</div>
</div>

<!-- PREVIEW -->
<div class="col-md-5">
<div class="preview shadow">

<h5>👀 Preview</h5>
<hr>

<div id="previewContent"></div>

</div>
</div>

</div>

</div>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

<script>
var editor = CKEDITOR.replace('editor', {
    height: 400,

    filebrowserUploadUrl: 'upload.php',

    toolbar: [
        { name: 'clipboard', items: ['Undo','Redo'] },
        { name: 'basicstyles', items: ['Bold','Italic','Underline'] },
        { name: 'paragraph', items: ['NumberedList','BulletedList'] },
        { name: 'styles', items: ['Font','FontSize'] },
        { name: 'colors', items: ['TextColor','BGColor'] },
        { name: 'insert', items: ['Image','Table','CodeSnippet'] }
    ]
});

// PREVIEW REALTIME
editor.on('change', function(){
    document.getElementById("previewContent").innerHTML = editor.getData();

    // autosave
    localStorage.setItem("draft", editor.getData());
});

// LOAD LẠI NHÁP
window.onload = function(){
    let draft = localStorage.getItem("draft");
    if(draft){
        editor.setData(draft);
    }
}
</script>

</body>
</html>
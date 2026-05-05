<?php
include(__DIR__ . "/../includes/db.php");

// Lấy danh sách chương
$chapters = $conn->query("SELECT * FROM chapters ORDER BY order_num");

// Lấy bài học hiện tại (nếu có)
$currentLesson = null;
$currentChapter = null;

if(isset($_GET['lesson'])){
    $id = (int)$_GET['lesson'];

    $result = $conn->query("SELECT * FROM lessons WHERE id=$id");

    if($result && $result->num_rows > 0){
        $currentLesson = $result->fetch_assoc();

        // Lấy chương của bài
        $cid = $currentLesson['chapter_id'];
        $c = $conn->query("SELECT * FROM chapters WHERE id=$cid");
        if($c && $c->num_rows > 0){
            $currentChapter = $c->fetch_assoc();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>C++ Learning System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.sidebar {
  min-height: 100vh;
}

.sidebar b {
  color: #0dcaf0;
}

.sidebar a {
  transition: 0.2s;
}

.sidebar a:hover {
  background: #444;
  border-radius: 5px;
}

.sidebar a.bg-primary {
  border-radius: 5px;
}
</style>

</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-3 bg-dark text-white sidebar p-0">

      <h4 class="p-3 m-0 border-bottom">📚 C++ Learning</h4>

      <!-- SEARCH -->
      <form action="search.php" method="GET" class="p-3 border-bottom">
        <input name="q" class="form-control" placeholder="Tìm bài học...">
      </form>

      <!-- DANH SÁCH CHƯƠNG -->
      <div class="p-2">
      <?php while($c = $chapters->fetch_assoc()) { ?>
        <div class="mb-2">
          <b><?= $c['title'] ?></b>

          <?php
          $lessons = $conn->query("SELECT * FROM lessons WHERE chapter_id=".$c['id']." ORDER BY order_num");
          while($l = $lessons->fetch_assoc()) {
          ?>
            <div>
              <a href="?lesson=<?= $l['id'] ?>"
                 class="text-white text-decoration-none d-block p-2
                 <?= (isset($_GET['lesson']) && $_GET['lesson']==$l['id']) ? 'bg-primary' : '' ?>">

                - <?= $l['title'] ?>
              </a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      </div>

    </div>

    <!-- CONTENT -->
    <div class="col-9 p-4">

      <?php if($currentLesson){ ?>

        <!-- Hiển thị chương -->
        <?php if($currentChapter){ ?>
          <h5 class="text-muted"><?= $currentChapter['title'] ?></h5>
        <?php } ?>

        <h2><?= $currentLesson['title'] ?></h2>
        <hr>

        <div>
          <?= $currentLesson['content'] ?>
        </div>

        <!-- BÀI TẬP -->
        <?php
        $ex = $conn->query("SELECT * FROM exercises WHERE lesson_id=".$currentLesson['id']);
        if($ex && $ex->num_rows > 0){
        ?>
          <hr>
          <h4>📝 Bài tập</h4>

          <?php while($e = $ex->fetch_assoc()){ ?>
            <div class="mt-3 p-3 border rounded">
              <h5><?= $e['title'] ?></h5>
              <p><?= $e['description'] ?></p>

              <a href="submit.php?id=<?= $e['id'] ?>" class="btn btn-primary mt-2">
                  Làm bài
              </a>
                <textarea name="code" class="form-control" rows="5" placeholder="Nhập code của bạn..."></textarea>
                <input type="hidden" name="exercise_id" value="<?= $e['id'] ?>">
                <button class="btn btn-primary mt-2">Nộp bài</button>
              </form>
            </div>
          <?php } ?>

        <?php } ?>

      <?php } else { ?>
        <h2>Chọn bài học bên trái 👈</h2>
      <?php } ?>

    </div>

  </div>
</div>

</body>
</html>
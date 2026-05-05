<?php
include(__DIR__ . "/../includes/db.php");

$q = $_GET['q'];

$res = $conn->query("SELECT * FROM lessons 
WHERE title LIKE '%$q%' OR content LIKE '%$q%'");
?>

<h2>Kết quả tìm kiếm</h2>

<?php while($r = $res->fetch_assoc()) { ?>
  <div>
    <a href="index.php?lesson=<?= $r['id'] ?>">
      <?= $r['title'] ?>
    </a>
  </div>
<?php } ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include(__DIR__ . "/../includes/db.php");

// check student
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$exercise_id = (int)$_GET['id'];

// lấy bài tập
$exercise = $conn->query("
SELECT * FROM exercises 
WHERE id=$exercise_id
")->fetch_assoc();

$message = "";

if($_POST){

    // lấy dữ liệu
    $code = trim($_POST['code']);
    $output = trim($_POST['output']);

    // VALIDATE
    if($code == ""){

        $message = "
        <div class='alert alert-danger mt-3'>
        ❌ Code không được để trống
        </div>
        ";

    }
    elseif($output == ""){

        $message = "
        <div class='alert alert-danger mt-3'>
        ❌ Output không được để trống
        </div>
        ";

    }
    elseif(strlen($code) > 10000){

        $message = "
        <div class='alert alert-danger mt-3'>
        ❌ Code quá dài
        </div>
        ";

    }
    else {

        $expected = trim($exercise['test_output']);

        // CHẤM BÀI
        if($output === $expected){

            $status = "Accepted";
            $score = 10;
            $result = "Đúng";

        } else {

            $status = "Wrong Answer";
            $score = 0;
            $result = "Sai";
        }

        // chống lỗi SQL
        $code = $conn->real_escape_string($code);
        $output = $conn->real_escape_string($output);

        // check submission tồn tại
        $check = $conn->query("
        SELECT id FROM submissions 
        WHERE user_id=$user_id 
        AND exercise_id=$exercise_id
        ");

        if($check->num_rows > 0){

            // UPDATE
            $sql = "
            UPDATE submissions 
            SET code='$code',
                output='$output',
                status='$status',
                created_at=NOW()
            WHERE user_id=$user_id 
            AND exercise_id=$exercise_id
            ";

        } else {

            // INSERT
            $sql = "
            INSERT INTO submissions(
                user_id,
                exercise_id,
                code,
                output,
                status
            )
            VALUES(
                $user_id,
                $exercise_id,
                '$code',
                '$output',
                '$status'
            )
            ";
        }

        if(!$conn->query($sql)){

            $message = "
            <div class='alert alert-danger mt-3'>
            ❌ Lỗi DB: ".$conn->error."
            </div>
            ";

        } else {

            $message = "
            <div class='alert alert-info mt-3'>
                <b>Kết quả:</b> $result <br>
                <b>Điểm:</b> $score
            </div>
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">

<title>Nộp bài</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f1f5f9;
}

.box{
    background:white;
    padding:25px;
    border-radius:16px;
}

</style>

</head>

<body>

<div class="container mt-4">

<div class="box shadow">

<h3>
📝 <?= $exercise['title'] ?>
</h3>

<hr>

<p><b>📥 Input:</b></p>

<pre><?= $exercise['test_input'] ?></pre>

<p><b>📤 Output cần đạt:</b></p>

<pre><?= $exercise['test_output'] ?></pre>

<hr>

<?= $message ?>

<form method="POST">

<label>Code của bạn</label>

<textarea
name="code"
class="form-control mb-2"
rows="6"><?= $_POST['code'] ?? '' ?></textarea>

<label>Output chương trình</label>

<input
name="output"
class="form-control mb-3"
value="<?= $_POST['output'] ?? '' ?>"
placeholder="Nhập kết quả chương trình">

<button
type="button"
onclick="runTest()"
class="btn btn-warning me-2">

⚡ Chạy thử

</button>

<button class="btn btn-primary">
🚀 Nộp bài
</button>

</form>

</div>

</div>

<script>

function runTest(){

    let output = document
    .querySelector('[name=\"output\"]')
    .value
    .trim();

    let expected = `<?= trim($exercise['test_output']) ?>`;

    if(output === expected){

        alert("✅ Đúng!");

    } else {

        alert("❌ Sai!");
    }
}

</script>

</body>
</html>
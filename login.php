<?php
session_start();
include("includes/db.php");

$error = "";

if($_POST){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $res = $conn->query($sql);

    if($res->num_rows > 0){
        $user = $res->fetch_assoc();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // redirect theo role
        if($user['role'] == 'admin'){
            header("Location: admin/");
        } elseif($user['role'] == 'teacher'){
            header("Location: teacher/");
        } else {
            header("Location: student/");
        }
        exit;

    } else {
        $error = "Sai tài khoản hoặc mật khẩu";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5" style="max-width:400px;">

<h3 class="mb-3">🔐 Đăng nhập</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">

<input name="username" class="form-control mb-2" placeholder="Username">

<input type="password" name="password" class="form-control mb-3" placeholder="Password">

<button class="btn btn-primary w-100">Đăng nhập</button>

</form>

</div>
<?php
session_start();
include("includes/db.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        // HASH PASSWORD VERIFY
        if(password_verify($password, $user['password'])){

            if($user['status'] != 'active'){

                $error = "Tài khoản chưa được duyệt!";

            } else {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // chuyển hướng role
                if($user['role'] == 'admin'){

                    header("Location: admin/");

                }
                elseif($user['role'] == 'teacher'){

                    header("Location: teacher/");

                }
                else{

                    header("Location: student/");
                }

                exit;
            }

        } else {

            $error = "Sai mật khẩu!";
        }

    } else {

        $error = "Không tồn tại tài khoản!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">

<title>Đăng nhập</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light d-flex align-items-center" style="height:100vh;">

<div class="container">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card p-4 shadow">

<h4 class="text-center mb-3">
🔐 Đăng nhập
</h4>

<?php if($error != ""){ ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php } ?>

<form method="POST">

<input type="text"
name="username"
class="form-control mb-3"
placeholder="Tên đăng nhập"
required>

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Mật khẩu"
required>

<button class="btn btn-primary w-100">
Đăng nhập
</button>

</form>

<div class="mt-3 text-center">

<a href="register.php">
Chưa có tài khoản? Đăng ký
</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>
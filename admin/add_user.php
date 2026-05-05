<?php
session_start();
include(__DIR__ . "/../includes/db.php");

if($_POST){
    $u = $_POST['username'];
    $p = $_POST['password'];
    $r = $_POST['role'];

    $conn->query("INSERT INTO users(username,password,role)
                  VALUES('$u','$p','$r')");

    header("Location: index.php");
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">

<h3>➕ Thêm user</h3>

<form method="POST">

<input name="username" class="form-control mb-2" placeholder="Username">

<input name="password" class="form-control mb-2" placeholder="Password">

<select name="role" class="form-control mb-3">
<option value="admin">Admin</option>
<option value="teacher">Teacher</option>
<option value="student">Student</option>
</select>

<button class="btn btn-success">Tạo</button>

</form>

</div>
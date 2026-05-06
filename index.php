<?php
session_start();

// chưa đăng nhập
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// đã đăng nhập → chuyển role
if($_SESSION['role'] == 'admin'){
    header("Location: admin/");
}
elseif($_SESSION['role'] == 'teacher'){
    header("Location: teacher/");
}
else{
    header("Location: student/");
}
exit;
?>
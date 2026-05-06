<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "cpp_learn"
);

if(!$conn){
    die("Lỗi kết nối DB");
}
?>
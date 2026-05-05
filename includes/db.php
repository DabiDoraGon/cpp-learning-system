<?php
$conn = new mysqli("localhost", "root", "", "cpp_learning");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
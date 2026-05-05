<?php
if(isset($_FILES['upload'])){

    $file = $_FILES['upload'];
    $name = time() . "_" . $file['name'];

    move_uploaded_file($file['tmp_name'], "../uploads/images/" . $name);

    $url = "/cpp_learning/uploads/images/" . $name;

    echo json_encode([
        "uploaded" => 1,
        "fileName" => $name,
        "url" => $url
    ]);
}
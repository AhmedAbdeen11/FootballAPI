<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = $_FILES['profileImg']['name'];
    $file_size = $_FILES['profileImg']['size'];
    $file_type = $_FILES['profileImg']['type'];
    $temp_name = $_FILES['profileImg']['tmp_name'];

    $location = "../uploads/";

    $imgName = generateRandomString() . ".png";
    $uploadFile = $location . $imgName;

    move_uploaded_file($temp_name, $uploadFile);
    echo $imgName;
} else {
    echo "Error";
}

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

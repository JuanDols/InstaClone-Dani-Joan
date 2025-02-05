<?php
session_start();
require 'db_connection.php';
$target_dir = "C:/SECURE_FOLDER/";
$uploadOk = 1;

//obtener hash md5 del contenido del archivo, eso sera el nombre de archivo
$md5filename = md5(basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $md5filename;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]); //getimagesize(C:/...) Pilla la ruta de cada archivo FILES > FileTo > Ruta(tmp_name)
  echo "<br><br>";
  if ($check == false) {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if ($uploadOk == 1) {
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
}


// Check file size
if ($uploadOk == 1) {
  if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
}


// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
// mime = archivo/extension
if ($uploadOk == 1) {
  if ($check["mime"] != "image/jpg" && $check["mime"] != "image/png" && $check["mime"] != "image/jpeg") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
}

if ($uploadOk == 1) {
  if ($check[0] == $check[1]) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

if ($uploadOk == 1) {
  $sql = "INSERT INTO photos(user_id, file_path, caption) VALUES (" . $_SESSION["logged_id"] . ", '" . $md5filename . "', '" . $_POST['caption'] . "')";
  $result = execQuery(getDbConnection(), $sql);
  //añadir a base de datos
  if ($result == true) {
    echo 'Yours photo get in the basedate';
    $uploadOk = 1;
  } else {
    echo "Error";
    $uploadOk = 0;
  }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  header('Location: profile.php?userid=' . $_SESSION["logged_id"]);
  // if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    header('Location: profile.php?userid=' . $_SESSION["logged_id"]);
    exit();
  } else {
    echo "Sorry, there was an error uploading your file.";
    header('Location: profile.php?userid=' . $_SESSION["logged_id"]);
    exit(); 
  }
}
?>
<?php
$target_dir = "C:/SECURE_FOLDER/";
$uploadOk = 1;

//obtener hash md5 del contenido del archivo, eso sera el nombre de archivo
$md5filename = md5(basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $md5filename;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

echo "<br><br>";
var_dump($_FILES["fileToUpload"]);
echo "<br><br>";

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  var_dump($check);
echo "<br><br>";
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}




// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
if($check["mime"] != "image/png" && $check["mime"] != "image/png" && $check["mime"] != "image/jpeg") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

//TODO comprobar dimensiones de la imagen

//TODO hacer insert de la imagen anadida en tabla photos, con el id del que sea el usuario que la ha subido


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    echo $_POST["userid"];
    //header('Location: profile.php?userid='.$_POST["userid"]);
        exit();
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>

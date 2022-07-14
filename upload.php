<?php
session_start();
if(empty($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
$error= '';

if($_POST){
  $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
  if (!$token || $token !== $_SESSION['token']) {
     $error = "Please Try Again.";
  } else {
    $username = $_SESSION['username'];


    $folder_path = hash('ripemd160', $username);
    if ( !is_dir( $folder_path) ) {
        mkdir( $folder_path  );       
    }
    
    $fileToUpload = $folder_path . '/' . basename($_FILES["fileToUpload"]["name"]);
    $file_extention = pathinfo($fileToUpload, PATHINFO_EXTENSION);
    if (file_exists($fileToUpload)) {
     $error= "File name exists already";
    }else if($_FILES["fileToUpload"]["size"] > 10148576) {
        $error= "Sorry, your file is too large.";
    }else if($file_extention != "jpg" && $file_extention != "png" && $file_extention != "jpeg"
    && $file_extention != "gif" && $file_extention != "pdf" ) {
       $error=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      
    }else{
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileToUpload)) {
            $error = "Successfully Upload";
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
    }
   
}
}


$_SESSION['token'] = md5(uniqid(mt_rand(), true));

?>

<html>
<title> Upload </title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="./plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./css/layout.css">
<link rel="stylesheet" href="./css/table.css">


<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
<?php include("layout.php");?>
<link rel="stylesheet" href="./css/upload.css">
<body>



<div class="wrapper">
<h1>Upload Document : </h1>
<div id="formContent" style="marging-top:100px;">
<form action="upload.php" method="post" enctype="multipart/form-data">
  
<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
  <div class="form-group" >
    <label style="color:black;" for="fileToUpload"> Select a file to upload </label>
  <input type="file" name="fileToUpload" id="fileToUpload">
</div>
<div class="form-group">
                <a style= "color:red;"> <?php echo $error ?>
 </div>
<div class="form-group">

<input type="submit" value="Upload File" name="submit">
</div>
</form>

</div>
</div>




</body>





</html>
<?php

session_start();
if(empty($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
$number_of_files = 0;

if($_POST){
    
    $folder_path = hash('ripemd160', $username);
    $files = glob($folder_path.'/' . "*");
    $file_path = $folder_path.'/'.$_POST['file'];
    if (!unlink($file_path)) {

        echo "Error, File not found";
    }
    else {
        echo "Success, your file has been deleted";
    }
}

?>


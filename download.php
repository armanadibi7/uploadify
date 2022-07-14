<?php

session_start();

$username = $_SESSION['username'];
$number_of_files = 0;
if(empty($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
if($_POST){
    
    $folder_path = hash('ripemd160', $username);
    $file = $folder_path.'/'.$_POST['filename'];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}else{
    echo "File do not exists";
}
}

?>
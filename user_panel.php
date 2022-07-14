<?php
session_start();



$username = $_SESSION['username'];


if(empty($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
$number_of_files = 0;
$files = glob($username.'/' . "*");
if ($files){
    $number_of_files = count($files);
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

$fileName = [];
$file_extention = [];
$file_size = [];

$folder_path = hash('ripemd160', $username);
foreach (new DirectoryIterator($folder_path ) as $file){
    if ($file->isFile()) {
        $fileName[] = $file->getFilename();
        $file_extention[] = $file->getExtension();
        $file_size[] = formatBytes($file->getSize());
    }


}


if($_POST){
  

    if($_POST['id'] == "download"){
  
        $files = glob($username.'/' . "*");
        $file_path = $username.'/'.$_POST['filename'];
        echo $file_path;
        if (file_exists($file_path)) {
            header("Cache-Control: public");
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="'.basename($_POST['filename']).'"');
            header('Content-Transfer-Emcoding: binary');

            readfile($file_path);
            exit;
        }

    }else if($_POST['id'] == "remove"){
        $files = glob($username.'/' . "*");
        $file_path = $username.'/'.$_POST['filename'];
        if (!unlink($file_path)) {
            header("Refresh:0");
        }
        else {
        
        }

    }

}


?>

<html>
<title>Welcome - <?php echo $username ?> </title>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<link href="./plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./css/layout.css">
<link rel="stylesheet" href="./css/table.css">
<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
<?php include("layout.php");?>
<body>

<div class="table-title">
    <h3>Uploaded Documents</h3>
    <label for="myTable" >Number of files uploaded : <?php echo $number_of_files ?>
</div>

<table class="table-fill" id="myTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>File Extention</th>
                            <th>Size</th>
                            <th>Download</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="table-hover">
                       <?php foreach ($fileName as $index => $value) : ?>
                        <tr>
                       
                            <td><?php echo $value; ?></td> 
                        
                            <td><?php echo ".$file_extention[$index]" ?></td> 
                            
                            
                            <td><?php echo "$file_size[$index]" ?></td> 

                           <td> 
                                <form action="download.php" method="post">
                                    <input type="hidden" name="id" value="download">
                                    <input type="hidden" name="filename" value="<?php echo $value; ?>">
                                    <input type="submit" value="Download" name="submit">

                                </form>
                           </td>
                           
                           <td><input type="button" onclick='remove("<?php  echo $value; ?>")' value="Remove" ></td>
                       </tr>

                       <?php endforeach; ?>
                                  

                    </tbody>
                </table>


</body>

<script>

    async function remove(filename) {
        var formData = {
        file: filename
    };
        
        $.ajax({
            url: "remove.php",
            type: 'post',
            data: formData ,
            success: function (response) {

                alert(response);
                location.reload();

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    }

   
</script>



</html>
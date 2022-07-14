<?php
session_start();

require_once('db.php');
if(empty($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
$error="";
$username =$_SESSION['username'];

$email = $_SESSION['email'];

function strongPassword($pass){
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    $specialChars = preg_match('@[^\w]@', $pass);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) {
        return false;
    }else{
        return true;
    }
}

if($_POST){

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token']) {
       $error = "Please Try Again.";
    } else {
            $current_pwd = $_POST['current_pwd'];
            $pwd = $_POST['pwd'];
            $confirmPwd = $_POST['confirmPwd'];
            if(!strongPassword($pwd)){
            
                $error = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            }else if($pwd === $current_pwd){
            
                $error = 'New password cannot be the same as the current password';
        
            }else{
            if($pwd === $confirmPwd){
                $conn = new mysqli($servername, $dbUser, $dbPwd, $dbname);
                $sql = "SELECT password FROM user WHERE email='".$email."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
            
                    while ($row = $result->fetch_assoc()) {
                        if (password_verify($current_pwd, $row['password'])) {
            
                            $pwd = password_hash($pwd, PASSWORD_DEFAULT);  
                            $sql = "UPDATE user SET password='".$pwd."' WHERE username='".$username."'";
                            if ($conn->query($sql) === TRUE) {
                                $error= "Password updated successfully";
                            } else {
                                $error= "Error updating record: " . $conn->error;
                            }
            
                            $conn->close();
                        } else {
                            $error = "Wrong Password, Try Again";
                        }
                    }
                }else{
                    $error = "Wrong Email or Password, Try Again";
                }
            }else{
                $error = "Password do not match";
            }
            
        } 
    }
}
?>

<html>
<title> Account Managment </title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="./plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./css/layout.css">
<link rel="stylesheet" href="./css/table.css">

<link rel="stylesheet" href="./css/upload.css">
<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; width=device-width;">
<?php include("layout.php");?>

<link rel="stylesheet" href="./css/upload.css">
<body>



<div class="wrapper">
    
<h1>Edit Account </h1>
<div id="formContent">
<form action="my_account.php" method="post" enctype="multipart/form-data">
    
<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
        <div class="form-group">
        <label for="my_account"> Name </label>
        <input type="text" name="account_name" value=<?php echo $username ?> >
        </div>
        <div class="form-group">
        <label for="email"> Email </label>
        <input type="email" name="email" disabled value=<?php echo $email ?>  >
        </div>
        <div class="form-group">
        <label for="pwd"> Current Password </label>
                <input type="password" name="current_pwd"  placeholder="Current Password" />
            </div>
        <div class="form-group">
        <label for="pwd"> Change Password </label>
                <input type="password" name="pwd"  placeholder="New Password" />
            </div>
        <div class="form-group">
            <input type="password" name="confirmPwd"   placeholder="Confirm Password" />
         </div>
         <div class="form-group">
                <a style= "color:red;"> <?php echo $error ?>
            </div>
         <div class="form-group">
                <input type="submit"  value="Save Change">
        </div>
</form>

</div>
</div>





</body>





</html>
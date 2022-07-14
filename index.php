<?php
ob_start();
session_start();
require_once('recaptchalib.php');
require_once('db.php');
$publickey = "6LctRN0gAAAAAIFwt0c2VAjCCr7SjW85wAPcu9Ok"; // you got this from the signup page
$error = "";
 echo recaptcha_get_html($publickey);


 function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

if( !empty($_SESSION['username'])){
    header("Location: user_panel.php");
    exit();
}
if($_POST){
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    if (!$token || $token !== $_SESSION['token']) {
       $error = "Please Try Again.";
    } else {
        if(!empty($_POST['email'] ) || !empty($_POST['password']) ){
       
            $email = $_POST['email'];
            $pwd = $_POST['password'];
            
            if(!checkemail($email)){
                 $error = "Invalid Email Address";
            }else{
    
                $conn = new mysqli($servername, $dbUser, $dbPwd, $dbname);
                $sql = "SELECT username,password,status,email FROM user WHERE email='".$email."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
    
                    while ($row = $result->fetch_assoc()) {
                        if (password_verify($pwd, $row['password'])) {
                            if($row['status'] == "active"){
                                $_SESSION['username'] = $row['username'];
                                
                                $_SESSION['email'] = $row['email'];
                                
                                
                                header("Location: user_panel.php");
                                 exit();
                            }else{
                                
                            $error = "Your account has been deactivated. Contact Customer Service please.";
                            }
                        } else {
                            $error = "Wrong Email or Password, Try Again";
                        }
                    }
                }else{
                    $error = "Wrong Email or Password, Try Again";
                }
                
              
            }
        
        }else{
            $error = "Invalid Request, Try Again";
        }
    }
    
}
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>
<html>

<Title>
    Log In

</title>

<link rel="stylesheet" href="./css/login_signup.css">
<div class="wrapper fadeInDown">
    <div id="formContent">
    <div class="form-group">
        <img src="./css/logo3.png" alt="uploadify" style="margin-top:10%;" >   
    </div>
        <!-- Tabs Titles -->
        <h2 class="active"> <a>Sign In </a> </h2>
        <h2 class="inactive"> <a href="signup.php">Sign Up </a> </h2>
        <!-- Icon -->
        <!-- Login Form -->
        <form id="index"  method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <div class="form-group">
                <input type="email" name="email" class="fadeIn second"  placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="password" name="password"  class="fadeIn third"  placeholder="Password" />
            </div>
            <div class="form-group">
                <a style= "color:red;"> <?php echo $error ?>
            </div>
            <div class="form-group">
                <input type="submit" class="fadeIn fourth" value="Log In">
            </div>
        </form>


    </div>
</div>

</html>
<?php
 require_once('recaptchalib.php');
 require_once('db.php');
 session_start();
 $error = "";


 function checkemail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function strongPassword($pass){
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@', $pass);
    $number    = preg_match('@[0-9]@', $pass);
    if(!$uppercase || !$lowercase || !$number || strlen($pass) < 8) {
        return false;
    }else{
        return true;
    }
}
function verifyUsername($username){
    $specialChars = preg_match('@[^\w]@', $username);
    $space =preg_match("/\\s/", $username);
    if($specialChars || strlen($username) > 10 || $space) {

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

    if(!empty($_POST['email'] ) || !empty($_POST['username']) || !empty($_POST['pwd']) ||!empty($_POST['confirmPwd'])){


        $email = $_POST['email'];
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];
        $confirmPwd = $_POST['confirmPwd'];
        if(!checkemail($email)){
             $error = "Invalid Email Address";
        }else if(!verifyUsername($username)){
            // Verify username characters
            $error= "Username cannot be more than 10 characters and cannot contain special character or space";
            
        }else{
            if($pwd === $confirmPwd){
                $conn = new mysqli($servername, $dbUser, $dbPwd, $dbname);
                $sql = "SELECT username FROM user WHERE username='".$username."'";
                $userCheck = $conn->query($sql);
                $sql = "SELECT email FROM user WHERE email='".$email."'";
                $emailCheck = $conn->query($sql);
                if(!strongPassword($pwd)){
                    // Verify password strong
                    $error = 'Password should be at least 8 characters in length and should include at least one upper case letter and one number';
                
                }else if($userCheck->num_rows > 0){
                    //verify if username or email exist already
                    $error = "This username or email is already taken";
                   

                }else if($emailCheck->num_rows > 0){
                    //verify if username or email exist already
                    $error = "This username or email is already taken";
                   

                }else{
                    //Create Account

                    $folder_path = hash('ripemd160', $username);
                    if ( !is_dir( $folder_path ) ) {
                        mkdir( $folder_path   );       
                    }
                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);  
                    $conn = new mysqli($servername, $dbUser, $dbPwd, $dbname);
                    $sql = "INSERT INTO user (username, password, email,status,file_path)
                    VALUES ('".$username."', '".$pwd."', '".$email."','active' , '".$folder_path."')";
                    if ($conn->query($sql) === TRUE) {
                        $conn->close();
                      
                        header("Location: index.php");
                        exit();
                      } else {
                        $error=  "Connection Error, Try again";
                      }
                      
                    
                       
                }
    
            }else{
    
                $error = "Password do not match";
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
<link rel="icon" href="/css/fav.png">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<Title>
    Sign Up
</title>

<link rel="stylesheet" href="./css/login_signup.css">
<div class="center">
</div>
<div class="wrapper fadeInDown">
    <div id="formContent">
    <div class="form-group">
        <img src="./css/logo3.png" alt="uploadify" style="margin-top:10%;" >   
    </div>
        <!-- Tabs Titles -->
        <h2 class="inactive"> <a href="index.php">Sign In </a> </h2>
        <h2 class="active"> <a >Sign Up </a> </h2>
        <!-- Icon -->
        <!-- Login Form -->
        <form id="signup.php" method="post">
            
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <div class="form-group">
             
                <input type="text" id="username" name="username" class="fadeIn second"  pattern="[A-Za-z0-9]{0,10}" title="(Maximum of 10 characters - letters and numbers only, no punctuation or special characters)" placeholder="Username" required/>
            </div>
           
            <div class="form-group">
                <input type="email" name="email" class="fadeIn second"  placeholder="Email" required/>
                
            </div>
            <div class="form-group">
                <input type="password" name="pwd" class="fadeIn third" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password should be at least 8 characters in length and should include at least one upper case letter and one number" placeholder="Password"  required/>
                
              </div>
   
            <div class="form-group">
            <input type="password" name="confirmPwd" class="fadeIn third"  placeholder="Confirm Password" required/>
            </div>
            <div class="form-group">
                <a style= "color:red;"> <?php echo $error ?>
            </div>
            <div class="form-group">
                <input type="submit" class="fadeIn fourth" value="Sign Up">
            </div>
        </form>

    

    </div>
</div>

</html>
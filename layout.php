
<?php



?>

    <link rel="stylesheet" href="./css/site.css" />
    <meta name="description" content="" />
    <script src="./js/constant.js"></script>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
 
    <link href="./css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="./css/layout.css" rel="stylesheet" type="text/css" />

<div id="header" class="navbar-toggleable-md sticky header-md clearfix">

    <!-- TOP NAV -->
    <header id="topNav">
        <div class="container">
        <a class="navbar-brand" href="user_panel.php">
        <img src="./css/logo3.png" alt="uploadify"  width="80" height="80"> 
      </a>
            <!-- Mobile Menu Button -->
            <button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            

            <!--
                Top Nav

                AVAILABLE CLASSES:
                submenu-dark = dark sub menu
            -->
            <div class="navbar-collapse collapse float-right nav-main-collapse submenu-dark">
                <nav class="nav-main">
                    
                    <ul id="topMain" class="nav nav-pills nav-main nav-onepage">
                    <li class="Home">
                        <a id="index" class="nav-link text-dark" title="Home" href="user_panel.php">Home</a>
                    </li> 
                    <li class="Upload">
                        <a id="index" class="nav-link text-dark" title="Upload" href="upload.php">Upload</a>
                    </li> 
                    <li class="nav-item">
                        <a id="account" class="nav-link text-dark" title="Account" href="my_account.php">Account</a>
                    </li>  
                    <li class="nav-item">
                        <a id="logout" class="nav-link text-dark" title="Logout" href="logout.php" >Logout - <?php echo $_SESSION['username'] ?></a>
                    </li>
                    </ul>

                </nav>
            </div>

        </div>
    </header>
    <!-- /Top Nav -->

</div>

<script src="./lib/jquery/dist/jquery.min.js"></script>
<script src="./lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/site.js" asp-append-version="true"></script>
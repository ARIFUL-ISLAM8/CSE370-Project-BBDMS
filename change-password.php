<?php
session_start();
error_reporting(0);
// Code for change password    
if(isset($_POST['submit'])) {
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $username = $_SESSION['alogin'];

    // Regular expressions to check for required characters
    $uppercaseRegex = '/[A-Z]/';
    $lowercaseRegex = '/[a-z]/';
    $specialCharRegex = '/[@#!%]/';
    $numberRegex = '/[0-9]/';

    if(preg_match_all($uppercaseRegex, $_POST['newpassword']) < 1) {
        $error = "New password must contain at least one uppercase letter.";
    } elseif(preg_match_all($lowercaseRegex, $_POST['newpassword']) < 1) {
        $error = "New password must contain at least one lowercase letter.";
    } elseif(preg_match_all($specialCharRegex, $_POST['newpassword']) < 1) {
        $error = "New password must contain at least one special character (@, #, !, %).";
    } elseif(preg_match_all($numberRegex, $_POST['newpassword']) < 1) {
        $error = "New password must contain at least one number.";
    } else {
        // Password meets the criteria, proceed with changing it
        $sql = "SELECT Password FROM login WHERE UserName=:username and Password=:password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0) {
            $con = "update login set Password=:newpassword where UserName=:username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password succesfully changed";
        } else {
            $error = "Your current password is not valid.";    
        }
    }
}
?>


<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <!-- Meta tag Keywords -->
    <!-- Custom-Files -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <!-- Web-Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    	<style>
    body {
        background-image: url('images/bg.jpg');
        background-size: cover; /* This ensures the image covers the entire background */
		background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevents the image from repeating */
    }
	</style>
</head>

<body>
    <!-- header -->
    <div id="home">
        <!-- navigation -->
        <div class="main-top py-1">
            <nav class="navbar navbar-expand-lg navbar-light fixed-navi">
                <div class="container">
                    <!-- logo -->
                    <h1>
                        <a class="navbar-brand font-weight-bold font-italic" href="index.php">
                            BBDMS
                            <i class="fas fa-syringe"></i>
                        </a>
                    </h1>
                    <!-- //logo -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="images/logpic.png" class="img-fluid" alt="Phone image" height="300px" width="600px">
                    </div>
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                            <?php if($error) { ?>
                                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                            <?php } else if($msg) { ?>
                                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Current Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                            </div>
                            <div class="hr-dashed"></div>                                          
                            <div class="form-group">
                                <label class="col-sm-4 control-label">New Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                                </div>
                            </div>
                            <div class="hr-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                                </div>
                            </div>
                            <div class="hr-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-4">                                
                                    <button class="btn btn-primary" name="submit" type="submit">Save changes</button>
                                </div>
                            </div>
                        </form>
                        <div class="card-footer text-center" style="padding-top: 30px;">
                            <div class="small"><a href="index.php" class="btn btn-primary">Back to Home</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Loading Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    	<!-- banner slider -->

	<!-- fixed navigation -->
	<script src="js/fixed-nav.js"></script>
	<!-- //fixed navigation -->

	<!-- smooth scrolling -->
	<script src="js/SmoothScroll.min.js"></script>
	<!-- move-top -->
	<script src="js/move-top.js"></script>
	<!-- easing -->
	<script src="js/easing.js"></script>
	<!--  necessary snippets for few javascript files -->
	<script src="js/medic.js"></script>

	<script src="js/bootstrap.js"></script>
	<!-- Necessary-JavaScript-File-For-Bootstrap -->

	<!-- //Js files -->
    <script type="text/javascript">
        function valid() {
            if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("New Password and Confirm Password do not match!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>

<?php
session_start();
include('includes/config.php');

if(isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    // Check if the user exists
    $sql = "SELECT u.User_ID, l.Username
            FROM User u
            INNER JOIN LogIn l ON u.LogID = l.LogID
            WHERE u.User_ID = :user_id AND l.Username = :username";

    $query = $dbh->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        if($newpassword === $confirmpassword) {
            // Check password complexity
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newpassword)) {
                echo "<script>alert('Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
                exit;
            }
            // Update password if user exists
            $hashed_password = md5($newpassword);

            $con = "UPDATE User AS u
                    INNER JOIN LogIn AS l ON u.LogID = l.LogID
                    SET l.Password = :hashed_password
                    WHERE u.User_ID = :user_id AND l.Username = :username";

            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
            $chngpwd1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->execute();
            echo "<script>alert('Your password has been successfully changed');</script>";
        } else {
            echo "<script>alert('New Password and Confirm Password do not match');</script>";
        }
    } else {
        echo "<script>alert('User ID or username is invalid');</script>";
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
                    <form method="post" name="chngpwd" onsubmit="return valid();">
                        <label for="user_id" class="text-uppercase text-sm">User ID</label>
                        <input type="text" class="form-control mb" name="user_id" placeholder="User ID" required="true">
                        <label for="username" class="text-uppercase text-sm">Username</label>
                        <input type="text" class="form-control mb" name="username" placeholder="Username" required="true">
                        <label for="newpassword" class="text-uppercase text-sm">New Password</label>
                        <input class="form-control mb" type="password" name="newpassword" placeholder="New Password" required="true"/>
                        <label for="confirmpassword" class="text-uppercase text-sm">Confirm Password</label>
                        <input class="form-control mb" type="password" name="confirmpassword" placeholder="Confirm Password" required="true" />
                        <button class="btn btn-primary btn-block" name="submit" type="submit">Reset</button>
                        <a href="index.php" class="btn btn-link">Sign in</a>
                    </form>
                    <div class="card-footer text-center" style="padding-top: 30px;">
                        <div class="small"><a href="index.php" class="btn btn-primary">Back to Home</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    	<!-- //banner slider -->

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

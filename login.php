<?php
session_start();
include('includes/config.php');
// Establish database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['login'])) 
{
    $sql = "SELECT * FROM `login` WHERE `Username`=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_POST['username']);
    mysqli_stmt_execute($stmt);
    
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);


    // Check if the query returned a row
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['Password'];

        echo "Hashed Password: " . $hashed_password . "<br>"; // Debugging

        if (md5($_POST['password']) == $hashed_password){

            $_SESSION['alogin'] = true; #After Logout we won't be able to go back

            $log_id = $row['LogID'];

            // Get user ID from User table
            $user_query = "SELECT User_ID FROM User WHERE LogID='$log_id'";
            $user_result = mysqli_query($conn, $user_query);
            $user_row = mysqli_fetch_assoc($user_result);
            $user_id = $user_row['User_ID'];
            echo "User ID: " . $user_id . "<br>"; // Debugging

            // Get user role from User table
            $role_query = "SELECT Role FROM User WHERE User_ID='$user_id'";
            $role_result = mysqli_query($conn, $role_query);
            $role_row = mysqli_fetch_assoc($role_result);
            $role = $role_row['Role'];
            echo "Role: " . $role . "<br>";

            // Handle the case where $role is 'Receiver' and change it to 'Patient'
            if ($role == 'Receiver') {
                $role = 'Patient';
            }
            
            // Get permission module from Permission table based on role
            $permission_query = "SELECT Per_Module FROM Permission WHERE Per_Name='$role'";
            $permission_result = mysqli_query($conn, $permission_query);
            $permission_row = mysqli_fetch_assoc($permission_result);
            $per_module = $permission_row['Per_Module'];
            echo "Permission Module: " . $per_module . "<br>";
            // Redirect based on permission module
            switch ($per_module) {
                case 'Admin panel':
                    header('location: admin/AdminPanel.php');
                    exit;
                case 'Hospital Panel':
                    header('location: Hospital/HospitalPanel.php?user_id=' . $user_id);
                    exit;
                case 'Donor panel':
                    header('location: Donor/DonorPanel.php?user_id=' . $user_id);
                    exit;
                case 'Patient Panel':
                    header('location: Patient/PatientPanel.php?user_id=' . $user_id);
                    exit;
                default:
                    echo "<script>alert('Invalid Permission Module');</script>";
                    exit;
            }            
        } else {
            echo "<script>alert('Username or password is incorrect');</script>";
        }
    } else {
        echo "<script>alert('Username or password is incorrect');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
	
	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="css/fontawesome-all.css">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->
	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<!-- //Web-Fonts -->
	<style>
    body {
        background-image: url('images/bg.jpg');
        background-size: cover; /* This ensures the image covers the entire background */
		background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevents the image from repeating */
    }
	</style>

    <script>
        function validateForm() {
            var username = document.forms["loginForm"]["username"].value;
            var password = document.forms["loginForm"]["password"].value;
            if (username == "" || password == "") {
                alert("Username and password are required");
                return false;
            }
        }
    </script>
</head>

<body>
<?php error_reporting(0);
session_start(); ?>
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
                    <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-lg-auto">
                            <li class="nav-item active mt-lg-0 mt-3">
                                <a class="nav-link" href="index.php">Home
                                    <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item mx-lg-4 my-lg-0 my-3">
                                <a class="nav-link" href="about.php">About Us</a>
                            </li>
                            <?php if (strlen($_SESSION['bbdmsdid']==0)) {?>
                        </ul> <?php } ?>
                    </div>
                </div>
            </nav>
        </div>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="images/logpic.png" class="img-fluid" alt="Phone image" height="300px" width="600px">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
				<form name="loginForm" action="" method="post" onsubmit="return validateForm()">
				    <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3">Login</p>
				    <!-- Username input -->
				    <div class="form-outline mb-4">
				        <label class="form-label" for="form1Example13"><i class="bi bi-person-circle"></i> Username</label>
				        <input type="text" id="form1Example13" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="Enter your username" style="border-radius:25px;" required />
				    </div>
				    <!-- Password input -->
				    <div class="form-outline mb-4">
				        <label class="form-label" for="form1Example23"><i class="bi bi-chat-left-dots-fill"></i> Password</label>
				        <input type="password" id="form1Example23" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="Enter your password" style="border-radius:25px;" required />
				    </div>
				    <!-- Submit button -->
				    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
				        <input type="submit" value="Log In" name="login" class="btn btn-danger btn-lg text-light my-2 py-3" style="width:100%; border-radius:30px; font-weight:600;" />
				    </div>
				</form><br>
                    <p align="center">I don't have any account 
                        <a href="Donor/donoraccount.php">
                            <i class="fas fa-user-plus mr-2"></i>Create Donor Account</a></p>
                    <p align="center">
                        <a href="Hospital/hospitalstaffaccount.php">
                            <i class="fas fa-user-plus mr-2"></i>Create Hospital Staff Account</a>
                    </p>
					<p class="account-w3ls text-center pb-4" style="color:#000">
					Forgot Password?
    					<a href="forgot-password.php">
							Click Here</a>
					</p>
                    <p class="account-w3ls text-center pb-4" style="color:#000">
					    Change Password?
    					<a href="change-password.php">Click Here</a>
					</p>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>
</html>

<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(isset($_POST['submit'])) {
    // Fetch form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password
    $position = $_POST['position'];
    $hospital_id = $_POST['hospital_id'];
    $role = 'Hospital Staff';
    $perId = 2;
    // Insert user login credentials into LogIn table
    $sql = "INSERT INTO LogIn (Username, Password) VALUES (:username, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $logId = $dbh->lastInsertId(); // Get last inserted LogID

    // Insert user details into User table
    $sql = "INSERT INTO User (Name, Role, LogID, Per_ID) VALUES (:name, :role, :logId, :perId)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':role', $role, PDO::PARAM_STR);
    $query->bindParam(':logId', $logId, PDO::PARAM_INT);
    $query->bindParam(':perId', $perId, PDO::PARAM_INT);
    $query->execute();
    $userId = $dbh->lastInsertId(); // Get last inserted UserID
    
    // Insert hospital staff details into HospitalStaff table
    $sql = "INSERT INTO HospitalStaff (User_ID, Position, Hospital_Id) 
            VALUES (:userId, :position, :hospital_id)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':position', $position, PDO::PARAM_STR);
    $query->bindParam(':hospital_id', $hospital_id, PDO::PARAM_INT);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
    echo "<script>alert('You have signup  Scuccessfully');</script>";
    }
    else
    {
    echo "<script>alert('Something went wrong.Please try again');</script>";
    }
    // Redirect to login page after successful registration
    header("Location: ../index.php");
    exit();
}

// Fetch hospital details based on the provided hospital ID
if(isset($_GET['hospital_id'])) {
    $hospital_id = $_GET['hospital_id'];
    $sql = "SELECT * FROM Hospital WHERE Hospital_Id = :hospital_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':hospital_id', $hospital_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    	<!-- Custom-Files -->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->
	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
	    rel="stylesheet">
	<!-- //Web-Fonts -->
  <script>
      function validateForm() {
          var name = document.forms["myForm"]["name"].value;
          var username = document.forms["myForm"]["username"].value;
          var password = document.forms["myForm"]["password"].value;
          var position = document.forms["myForm"]["position"].value;
          var hospital_id = document.forms["myForm"]["hospital_id"].value;

          if (name == '' || username == '' || password == '' || position == '' || hospital_id == '') {
              alert("Please fill in all fields");
              return false;
          }
      }
  </script>

</head>

<body style="background-color: #eee;">
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
                        <a class="navbar-brand font-weight-bold font-italic" href="../index.php">
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
    </div> 

    <!-- Sign-up Section -->
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <!-- Sign-up Card -->
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-2">
                            <div class="row justify-content-center">
                                <p class="text-center h1 fw-bold mb-4 mx-1 mx-md-3 mt-3">Sign up</p>
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <!-- Sign-up Form -->
                                    <form action="#" method="post"  name="signup" onsubmit="return validateForm();">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="username"><i class="bi bi-envelope-at-fill"></i> Username</label>
                                                <input type="text" id="username" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="Enter your username" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="password"><i class="fas fa-lock fa-lg fa-fw"></i> Password</label>
                                                <input type="password" id="password" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="Enter your password" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="name"><i class="bi bi-person-circle"></i> Name</label>
                                                <input type="text" id="name" class="form-control form-control-lg py-3" name="name" autocomplete="off" placeholder="Enter your name" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="position"><i class="bi bi-person-badge"></i> Position</label>
                                                <input type="text" id="position" class="form-control form-control-lg py-3" name="position" autocomplete="off" placeholder="Enter your position" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="hospital_id"><i class="bi bi-hospital"></i> Hospital ID</label>
                                                <input type="text" id="hospital_id" class="form-control form-control-lg py-3" name="hospital_id" autocomplete="off" placeholder="Enter hospital ID" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary submit mb-4" name="submit">Register</button>
                                    </form>

                                    <p align="center">I already have an account <a href="../index.php" class="text-warning" style="font-weight:600; text-decoration:none;">Login</a></p>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="../images/signup.png" class="img-fluid" alt="Sample image" height="300px" width="500px">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>

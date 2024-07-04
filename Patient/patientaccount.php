<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['username'];
    $password = md5($_POST['password']); // Hash password
    $role = 'Patient';
    $perId = 4;
    // Check if the same username and password exist in the database
    $sqlCheck = "SELECT COUNT(*) as count FROM LogIn WHERE Username = :username AND Password = :password";
    $queryCheck = $dbh->prepare($sqlCheck);
    $queryCheck->bindParam(':username', $email, PDO::PARAM_STR);
    $queryCheck->bindParam(':password', $password, PDO::PARAM_STR);
    $queryCheck->execute();
    $result = $queryCheck->fetch(PDO::FETCH_ASSOC);

    if($result['count'] > 0) {
        // Alert user to change the password if same username and password exist
        echo '<script>alert("Please choose a different username or password.");</script>';
    } else {
        // Insert user into User table
        $sql = "INSERT INTO LogIn (Username, Password) VALUES (:username, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $logId = $dbh->lastInsertId(); // Get last inserted LogID
    
        // Insert user into User table
        $sql = "INSERT INTO User (Name, Role, LogID, Per_ID) VALUES (:name, :role, :logId, :perId)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        $query->bindParam(':logId', $logId, PDO::PARAM_INT);
        $query->bindParam(':perId', $perId, PDO::PARAM_INT);
        $query->execute();
        $userId = $dbh->lastInsertId(); // Get last inserted UserID
        
        // Insert patient into Patient table
        $blood_group = $_POST['blood_group'];
        $age = $_POST['age'];
        $hospitalId = $_POST['hospital_id'];
        $sql = "INSERT INTO Patient (User_ID, Blood_Group, Age, Hospital_Id) VALUES (:userId, :blood_group, :age, :hospitalId)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':blood_group', $blood_group, PDO::PARAM_INT);
        $query->bindParam(':age', $age, PDO::PARAM_INT);
        $query->bindParam(':hospitalId', $hospitalId, PDO::PARAM_STR);
        $query->execute();

        // Insert issue into Issue table
        $issue = $_POST['issue'];
        $sql = "INSERT INTO Issue (User_ID, Issues) VALUES (:userId, :issue)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':issue', $issue, PDO::PARAM_STR);
        $query->execute();

        // Insert emergency contact into EmergencyContact table
        $emergencyContactName = $_POST['emergency_contact_name'];
        $relationship = $_POST['relationship'];
        $emergencyContact = $_POST['emergency_contact'];
        $sql = "INSERT INTO EmergencyContact (User_ID, Contact, Relationship) VALUES (:userId, :emergencyContact, :relationship)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':emergencyContact', $emergencyContact, PDO::PARAM_STR);
        $query->bindParam(':relationship', $relationship, PDO::PARAM_STR);
        $query->execute();

        // Insert contact name into ContactName table
        $contactId = $dbh->lastInsertId(); // Get last inserted Contact_ID
        $sql = "INSERT INTO ContactName (Contact_ID, Name) VALUES (:contactId, :emergencyContactName)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':contactId', $contactId, PDO::PARAM_INT);
        $query->bindParam(':emergencyContactName', $emergencyContactName, PDO::PARAM_STR);
        $query->execute();

        // Insert into PatientContact table
        $sql = "INSERT INTO PatientContact (User_ID, Contact) VALUES (:userId, :emergencyContact)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->bindParam(':emergencyContact', $emergencyContact, PDO::PARAM_STR);
        $query->execute();

    // Redirect to login page after successful registration
        header("Location: ../index.php");
        exit();
    }
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
                                    <form action="#" method="post"  name="signup" onsubmit="return checkpass();">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example3c"><i class="bi bi-envelope-at-fill"></i> Username</label>
                                                <input type="username" id="form3Example3c" class="form-control form-control-lg py-3" name="username" autocomplete="off" placeholder="Enter your username" style="border-radius:25px ;" />

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c"><i class="fas fa-lock fa-lg fa-fw"></i> Password</label>
                                                <input type="password" id="form3Example4c" class="form-control form-control-lg py-3" name="password" autocomplete="off" placeholder="Enter your password" style="border-radius:25px ;" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example1c"><i class="bi bi-person-circle"></i> Patient's Name</label>
                                                <input type="text" id="form3Example1c" class="form-control form-control-lg py-3" name="name" autocomplete="off" placeholder="Enter patient's name" style="border-radius:25px ;" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example10c"><i class="fas fa-tint fa-lg fa-fw"></i> Blood Group</label>
                                                <select class="form-select form-select-lg" id="form3Example10c" name="blood_group" style="border-radius:25px ;">
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="age"><i class="bi bi-calendar2"></i> Age</label>
                                                <input type="number" id="age" class="form-control form-control-lg py-3" name="age" autocomplete="off" placeholder="Enter patient's age" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="hospital_id"><i class="fas fa-hospital"></i> Hospital ID</label>
                                                <input type="text" id="hospital_id" class="form-control form-control-lg py-3" name="hospital_id" autocomplete="off" placeholder="Enter hospital ID" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="issue"><i class="bi bi-exclamation-diamond"></i> Issue</label>
                                                <input type="text" id="issue" class="form-control form-control-lg py-3" name="issue" autocomplete="off" placeholder="Enter patient's issue" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="emergency_contact_name"><i class="bi bi-person"></i> Emergency Contact Name</label>
                                                <input type="text" id="emergency_contact_name" class="form-control form-control-lg py-3" name="emergency_contact_name" autocomplete="off" placeholder="Enter emergency contact's name" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="relationship"><i class="bi bi-people"></i> Relationship</label>
                                                <input type="text" id="relationship" class="form-control form-control-lg py-3" name="relationship" autocomplete="off" placeholder="Enter relationship with emergency contact" style="border-radius:25px ;" />
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="emergency_contact"><i class="bi bi-telephone"></i> Emergency Contact</label>
                                                <input type="text" id="emergency_contact" class="form-control form-control-lg py-3" name="emergency_contact" autocomplete="off" placeholder="Enter emergency contact number" style="border-radius:25px ;" />
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
